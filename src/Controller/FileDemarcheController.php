<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-05-09 21:15:58 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-05-10 10:37:31
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Demande;
use App\Form\DocumentDemande\DemandeNonValidateType;
use App\Manager\{DocumentAFournirManager, MailManager, DemandeManager};

class FileDemarcheController extends AbstractController
{
    /**
     * @Route("/validate_demande/{demande}/check", name="validate_file")
     */
    public function validateFile(
        Demande $demande,
        DocumentAFournirManager $documentManager,
        MailManager $mailManager
    )
    {
        $infos = $documentManager->getFilesList($demande);
        $response = $mailManager->sendMailDocumentAFournir($demande, $infos);

        
        return $this->redirect($this->generateUrl('demande_dossiers_a_fournir', ["id" => $demande->getId()]));
    }

    /**
     * @Route("/validate/{demande}/document/{checker}", name="demande_document_validate")
     */
    public function validerDocument(Demande $demande, $checker, DemandeManager $demandeManager)
    {
        if ($demande->getChecker() != $checker ) {
            Throw new \Exception("Check lien de l'email non valide");
        }
        $demande->setStatusDoc(Demande::DOC_VALID);
        $demandeManager->saveDemande($demande);

        return new Response('success');
    }

    /**
     * @Route("/nonvalidate/{demande}/document/{checker}", name="demande_document_nonvalidate")
     */
    public function nonValiderDocument(Demande $demande, $checker, DemandeManager $demandeManager, Request $request)
    {
        if ($demande->getChecker() != $checker ) {
            Throw new \Exception("Check lien de l'email non valide");
        }
        $form = $this->createForm(DemandeNonValidateType::class, $demande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $demande->setStatusDoc(Demande::DOC_NONVALID);
            $demandeManager->saveDemande($demande);

            return $this->redirect($this->generateUrl("notification_success"));
        }

        return $this->render(
            'demande/motif_reject.html.twig',
            [
                "form" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/success/notification_document_demande", name="notification_success")
     */
    public function notificationSuccess()
    {
        return $this->render(
            'demande/notificationSuccess.html.twig'
        );
    }
}
