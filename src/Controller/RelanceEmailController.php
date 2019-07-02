<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/relance")
 */
class RelanceEmailController extends AbstractController
{
    /**
     * @Route("/email_1", name="relance_email_1")
     */
    public function relance(\Swift_Mailer $mailer)
    {
        $responses = $this->getUser();
        $response = $this->getUser()->getEmail();
        $this->send($mailer, $response, $responses);

        return new Response('ok');
    }

    public function send($mailer, $mail, $responses)
    {
        $message = (new \Swift_Message('Hello!'))
        ->setFrom('no-reply@cgofficiel.fr');
        $message->setTo($mail);
        $message
        ->setBody(
            $this->renderView(
                'relance/email3.html.twig',
                array('responses' => $responses)
            ),
            'text/html'
        );
        $mailer->send($message);
    }
}