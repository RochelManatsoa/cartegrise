<?php
// src/Controller/CRUDController.php

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Manager\DocumentAFournirManager;
use App\Manager\{DemandeManager, CommandeManager, TMSSauverManager};
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Demande;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ActionAdminController extends Controller
{
    /**
     * @param $id
     */
    public function factureAction($id)
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        return new RedirectResponse($this->generateUrl('payment_facture', ['demande'=> $object->getId()]));

        // if you have a filtered list and want to keep your filters after the redirect
        // return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }

    /**
     * @param $id
     */
    public function deleteCommandeAction($id, CommandeManager $commandeManager)
    {
        $object = $this->admin->getSubject();
        if (!$object instanceof User) {
            throw new NotFoundHttpException(sprintf('unable to find the User with id: %s', $id));
        }
        $user = $object;
        $client = $user->getClient();
        $commandes = $client->getCommandes();
        foreach ($commandes as $commande)
        {
            $commandeManager->remove($commande);
        }
        $commandeManager->flush();

        // if you have a filtered list and want to keep your filters after the redirect
        return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }

    /**
     * @param $id
     */
    public function facturejournalierAction($id)
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        return new BinaryFileResponse($object->getPath());
        // if you have a filtered list and want to keep your filters after the redirect
        // return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }

    /**
     * @param $id
     */
    public function dossierAction(
        $id,
        DocumentAFournirManager $documentAFournirManager,
        DemandeManager $demandeManager,
        CommandeManager $commandeManager,
        Request $request,
        TMSSauverManager $tmsSauverManager
    )
    {
        $demande = $this->admin->getSubject();

        if (!$demande) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        $files = $documentAFournirManager->getDaf($demande);
        $fileType = $documentAFournirManager->getType($demande);
        $pathCerfa = $demandeManager->generateCerfa($demande);
        $daf = $demandeManager->getDossiersAFournir($demande, $pathCerfa);
        if (!null == $fileType) {
            $fileForm = $this->createForm($fileType, $files);
        }
        if ($request->getMethod() === "POST") {
            if ($request->request->get('valid_doc_simulate') === "on") {
                $demande->setStatusDoc(Demande::DOC_VALID);
                $demandeManager->saveDemande($demande);
            } elseif ($request->request->get('valid_doc_real') === "on") {
                $tmsResponse = $commandeManager->tmsSauver($demande->getCommande());
                if ($tmsResponse->isSuccessfull()) {
                    // $demande->setStatusDoc(Demande::DOC_RECEIVE_VALID);
                    $demande->getCommande()->setSaved(true);
                    $demandeManager->saveDemande($demande);
                    $this->addFlash('success', 'La demande '.$demande->getCommande()->getId().' a bien été enregister sur TMS');
                }
                
            } elseif ($request->request->get('invalidate_doc_simulate') != "") {
                $demande->setStatusDoc(Demande::DOC_NONVALID);
                $demande->setMotifDeRejet($request->request->get('invalidate_doc_simulate'));
                $demandeManager->saveDemande($demande);
            }
        }

        $paramTmsInfos = $tmsSauverManager->getParamsForCommande($demande->getCommande());

        return $this->renderWithExtraParams('CRUD/view_document_detail.html.twig', [
            'demande'   => $demande,
            'form'      => is_null($fileForm) ? null :$fileForm->createView(),
            'daf'       => $daf,
            'files'     => $files,
            'tmsInfos'  => $paramTmsInfos["Lot"]["Demarche"],
            ]);
        

        // return new RedirectResponse($this->generateUrl('payment_facture', ['demande'=> $object->getId()]));

        // if you have a filtered list and want to keep your filters after the redirect
        // return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }
    /**
     * @param $id
     */
    public function uploadDossierAction(
        $id,
        DemandeManager $demandeManager, 
        DocumentAFournirManager $documentAFournirManager,
        Request $request
    )
    {
        $demande = $this->admin->getSubject();

        $pathCerfa = $demandeManager->generateCerfa($demande);
        $daf = $demandeManager->getDossiersAFournir($demande, $pathCerfa);
        $files = $documentAFournirManager->getDaf($demande);
        $fileType = $documentAFournirManager->getType($demande);
        $path = $demande->getUploadPath();
        $fileForm = null;
        if (!null == $fileType) {
            $fileForm = $this->createForm($fileType, $files);
            $fileForm->handleRequest($request);

            if ($fileForm->isSubmitted() && $fileForm->isValid()) {
                $documentAFournirManager->handleForm($fileForm, $path)->save($fileForm);
            }
        }

        return $this->render('CRUD/dossiers_a_fournir.html.twig', [
            'demande'   => $demande,
            'daf'       => $daf,
            'pathCerfa' => $pathCerfa,
            'form'      => is_null($fileForm) ? null :$fileForm->createView(),
            'client'    => $demande->getCommande()->getClient(),
            "files"     => $files,
        ]);
        

        // return new RedirectResponse($this->generateUrl('payment_facture', ['demande'=> $object->getId()]));

        // if you have a filtered list and want to keep your filters after the redirect
        // return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }
}