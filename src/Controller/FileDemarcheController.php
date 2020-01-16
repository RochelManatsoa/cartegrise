<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-05-09 21:15:58 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-06-20 14:38:52
 */
namespace App\Controller;

use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Demande;
use App\Manager\{DocumentAFournirManager, MailManager, DemandeManager};
use App\Annotation\MailDocumentValidator;

class FileDemarcheController extends AbstractController
{
    /**
     * @Route("/validate_demande/{demande}/check", name="validate_file")
     */
    public function validateFile(
        Demande $demande,
        DocumentAFournirManager $documentManager,
        MailManager $mailManager,
        Request $request
    )
    {
        $infos = $documentManager->getFilesList($demande);
        $response = $mailManager->sendMailDocumentAFournir($demande, $infos);
        $referer = $request->headers->get('referer');

        return $this->redirect($referer);
    }

    /**
     * @MailDocumentValidator(property="checker", entity="demande", invalidMessage="docInvalidMessage")
     * @Route("/validate/{demande}/document/{checker}", name="demande_document_validate")
     */
    public function validerDocument(
        Demande $demande, $checker, 
        MailManager $mailManager, 
        Swift_Mailer $mailer,
        DemandeManager $demandeManager
    )
    {
        $mail = $demande->getCommande()->getClient()->getUser()->getEmail();
        $demande->setStatusDoc(Demande::DOC_VALID);
        $demandeManager->saveDemande($demande);
        $mailManager->sendEmailStatusDoc($mailer, $mail, $demande, 2);

        return new Response('success');
    }

    /**
     * @MailDocumentValidator(property="checker", entity="demande", invalidMessage="docInvalidMessage")
     * @Route("/nonvalidate/{demande}/document/{checker}", name="demande_document_nonvalidate")
     */
    public function nonValiderDocument(
        Demande $demande, $checker, 
        MailManager $mailManager, 
        Swift_Mailer $mailer,
        DemandeManager $demandeManager, 
        Request $request
    )
    {
        $mail = $demande->getCommande()->getClient()->getUser()->getEmail();
        $form = $demandeManager->generateFormDeniedFiles($demande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $demande->setStatusDoc(Demande::DOC_NONVALID);
            $demandeManager->saveDemande($demande);
            $mailManager->sendEmailStatusDoc($mailer, $mail, $demande, 3);

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
