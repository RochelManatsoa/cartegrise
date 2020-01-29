<?php
// src/Controller/CRUDController.php

namespace App\Controller;

use Swift_Mailer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Manager\DocumentAFournirManager;
use App\Manager\{DemandeManager, CommandeManager, TMSSauverManager, ClientManager, MailManager};
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\{Demande, Commande, Facture};
use App\Entity\Client;
use App\Entity\Avoir;
use App\Form\SaveAndValidateType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Manager\Mercure\MercureManager;
use App\Manager\NotificationManager;

class ActionAdminController extends Controller
{
    public function __construct(DemandeManager $demandeManager){
        $this->demandeManager = $demandeManager;
    }
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
    public function factureCommandeAction($id)
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }
        if ($object instanceof Demande || $object instanceof Facture) {
            return new RedirectResponse($this->generateUrl('payment_facture_commande', ['commande'=> $object->getCommande()->getId()]));
        } elseif ($object instanceof Commande) {
            return new RedirectResponse($this->generateUrl('payment_facture_commande', ['commande'=> $object->getId()]));
        }

        // if you have a filtered list and want to keep your filters after the redirect
        // return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }
    /**
     * @param $id
     */
    public function commandeFactureAction($id)
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        return new RedirectResponse($this->generateUrl('payment_facture_commande', ['commande'=> $object->getId()]));

        // if you have a filtered list and want to keep your filters after the redirect
        // return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }

    /**
     * @param $id
     */
    public function avoirAction($id)
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        return new RedirectResponse($this->generateUrl('payment_avoir', ['demande'=> $object->getId()]));

        // if you have a filtered list and want to keep your filters after the redirect
        // return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }

    /**
     * @param $id
     */
    public function avoirCommandeAction($id)
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        return new RedirectResponse($this->generateUrl('payment_avoir_commande', ['commande'=> $object->getId()]));

        // if you have a filtered list and want to keep your filters after the redirect
        // return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }

    /**
     * @param $id
     */
    public function retracterAction($id, DemandeManager $demandeManager)
    {
        $object = $this->admin->getSubject();

        $object = $this->getDemandeInObject($object);

        if (!$object && !$object instanceof Demande) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }
        if (is_null($object->getAvoir())) {
            $avoir = new Avoir();
            $object->setAvoir($avoir);
        }
        
        $file = $demandeManager->generateAvoir($object);

        // return new RedirectResponse($this->generateUrl('payment_avoir', ['demande'=> $object->getId()]));

        // if you have a filtered list and want to keep your filters after the redirect
        return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }
    /**
     * @param $id
     */
    public function retracterWithDocumentAction($id, DemandeManager $demandeManager)
    {
        $object = $this->admin->getSubject();
        $object = $this->getDemandeInObject($object);

        if (!$object && !$object instanceof Demande) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }
        
        $file = $demandeManager->retracter($object);

        // return new RedirectResponse($this->generateUrl('payment_avoir', ['demande'=> $object->getId()]));

        // if you have a filtered list and want to keep your filters after the redirect
        return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }
    /**
     * @param $id
     */
    public function retracterCommandeAction($id, CommandeManager $commandeManager)
    {
        $object = $this->admin->getSubject();

        if (!$object && !$object instanceof Commande) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }
        // generate new Avoir
        if (is_null($object->getAvoir())) {
            $avoir = new Avoir();
            $object->setAvoir($avoir);
        }
        $file = $commandeManager->generateAvoir($object);
        $commandeManager->retracter($object);

        // return new RedirectResponse($this->generateUrl('payment_avoir', ['demande'=> $object->getId()]));

        // if you have a filtered list and want to keep your filters after the redirect
        return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }
    /**
     * @param $id
     */
    public function retracterCommandeSecondAction($id, CommandeManager $commandeManager)
    {
        $object = $this->admin->getSubject();

        $commandeManager->retracterSecond($object);

        // return new RedirectResponse($this->generateUrl('payment_avoir', ['demande'=> $object->getId()]));

        // if you have a filtered list and want to keep your filters after the redirect
        return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }
    /**
     * @param $id
     */
    public function refundCommandeAction($id, CommandeManager $commandeManager)
    {
        $object = $this->admin->getSubject();

        $commandeManager->refund($object);

        // return new RedirectResponse($this->generateUrl('payment_avoir', ['demande'=> $object->getId()]));

        // if you have a filtered list and want to keep your filters after the redirect
        return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }

    /**
     * @param $id
     */
    public function refundAction($id, DemandeManager $demandeManager)
    {
        $object = $this->admin->getSubject();
        $object = $this->getDemandeInObject($object);

        if (!$object && !$object instanceof Demande) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }
        
        $file = $demandeManager->refund($object);

        // return new RedirectResponse($this->generateUrl('payment_avoir', ['demande'=> $object->getId()]));

        // if you have a filtered list and want to keep your filters after the redirect
        return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }

    /**
     * @param $id
     */
    public function ficheClientAction(Client $object, ClientManager $clientManager)
    {

        return $this->renderWithExtraParams('CRUD/client/ficheClientView.html.twig', [
                'client'   => $object
            ]);
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
    public function newDemandeOfCommandeAction(
        $id,
        Request $request,
        DemandeManager $demandeManager,
        MercureManager  $mercureManager,
        NotificationManager $notificationManager
    )
    {
        $object = $this->admin->getSubject();
        if (!$object instanceof Commande) {
            throw new NotFoundHttpException(sprintf('unable to find the User with id: %s', $id));
        }

        $form = $demandeManager->generateForm($object);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $demande = $demandeManager->save($form);

            $commande = $object;

            // The Publisher service is an invokable object
            $data =  [
                'immat' => $commande->getImmatriculation(),
                'department' => $commande->getCodePostal(),
                'demarche' => $commande->getDemarche()->getType(),
                'id' => $demande->getId(),
            ];
            $mercureManager->publish(
                'http://cgofficiel.com/addNewSimulator',
                'demande',
                $data,
                'nouvelle demande insérer'
            );
            $notificationManager->saveNotification([
                "type" => 'demande', 
                "data" => $data,
            ]);
            // end update
            // redirect after save
            return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
        }

        return new Response($demandeManager->getAdminView($form));
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
        MailManager $mailManager,
        Swift_Mailer $mailer,
        Request $request,
        TMSSauverManager $tmsSauverManager
    )
    {
        $object = $this->admin->getSubject();

        $demande = $this->getDemandeInObject($object);

        if (!$demande) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        $mail = $demande->getCommande()->getClient()->getUser()->getEmail();

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
                $mailManager->sendEmailStatusDoc($mailer, $mail, $demande, 1);
            } elseif ($request->request->get('valid_doc_real') === "on") {
                $tmsResponse = $commandeManager->tmsSauver($demande->getCommande());
                if ($tmsResponse->isSuccessfull()) {
                    // $demande->setStatusDoc(Demande::DOC_RECEIVE_VALID);
                    $demande->getCommande()->setSaved(true);
                    $demande->setStatusDoc(Demande::DOC_VALID_SEND_TMS);
                    $demandeManager->saveDemande($demande);
                    $mailManager->sendEmailStatusDoc($mailer, $mail, $demande, 2);
                    $this->addFlash('success', 'La demande '.$demande->getCommande()->getId().' a bien été enregister sur TMS');
                }
                
            } elseif ($request->request->get('invalidate_doc_simulate') != "") {
                $demande->setStatusDoc(Demande::DOC_NONVALID);
                $demande->setMotifDeRejet($request->request->get('invalidate_doc_simulate'));
                $demandeManager->saveDemande($demande);
                $mailManager->sendEmailStatusDoc($mailer, $mail, $demande, 3);
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
    
    private function getDemandeInObject($object){
        $demande = null;
        if ($object instanceof Demande){
            $demande = $object;
        } elseif($object instanceof Commande) {
            $demande = $this->demandeManager->getRepository()->findOneBy(['commande'=>$object->getId()]);
        }

        return $demande;
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
        $object = $this->admin->getSubject();
        $demande = $this->getDemandeInObject($object);

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
                $parent = $fileForm->getData()->getParent();
                if ($demande){
                    $parent->setDemande($demande);
                    $demandeManager->persist($demande);
                }
                
                $documentAFournirManager->handleForm($fileForm, $path)->save($fileForm);
            }

            if($request->request->get('validate') === 'on') {
                return $this->redirectToRoute('validate_file', ['demande' => $demande->getId()]);
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