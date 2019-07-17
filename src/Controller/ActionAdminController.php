<?php
// src/Controller/CRUDController.php

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Manager\DocumentAFournirManager;
use App\Manager\DemandeManager;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Demande;

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
    public function dossierAction($id, DocumentAFournirManager $documentAFournirManager, DemandeManager $demandeManager, Request $request)
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
                $demande->setStatusDoc(Demande::DOC_RECEIVE_VALID);
                $demandeManager->saveDemande($demande);
            } elseif ($request->request->get('invalidate_doc_simulate') != "") {
                $demande->setStatusDoc(Demande::DOC_NONVALID);
                $demande->setMotifDeRejet($request->request->get('invalidate_doc_simulate'));
                $demandeManager->saveDemande($demande);
            }
        }

        return $this->renderWithExtraParams('CRUD/view_document_detail.html.twig', [
            'demande'   => $demande,
            'form'      => is_null($fileForm) ? null :$fileForm->createView(),
            'daf'       => $daf,
            'files'     => $files,
            ]);
        

        // return new RedirectResponse($this->generateUrl('payment_facture', ['demande'=> $object->getId()]));

        // if you have a filtered list and want to keep your filters after the redirect
        // return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
    }
}