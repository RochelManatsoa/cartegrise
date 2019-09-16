<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Demande;
use App\Manager\{DocumentAFournirManager, MailManager, DemandeManager};
use App\Annotation\MailDocumentValidator;

class MailDocumentController extends AbstractController
{
    /**
     * @Route("/email/{demande}/document/{checker}", name="demande_email_send")
     */
    public function emailValidate(\Swift_Mailer $mailer, Demande $demande, $checker)
    {
        $demandeChecker = $demande->getChecker();
        $index = ($demandeChecker == null ? "1" : "2");
        $response = $this->getUser()->getEmail();
        $this->send($mailer, $response, $demande, $index);

        return $this->redirectToRoute('notification_success');
    }

    public function send($mailer, $mail, $responses, $index)
    {
        $message = (new \Swift_Message('Hello!'))
        ->setFrom('no-reply@cgofficiel.fr');
        $message->setTo($mail);
        $message
        ->setBody(
            $this->renderView(
                'email/emailValidate'.$index.'.html.twig',
                array('responses' => $responses)
            ),
            'text/html'
        );
        $mailer->send($message);
    }
}