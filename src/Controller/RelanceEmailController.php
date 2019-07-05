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
     * @Route("/email/{index}", name="relance_email_1")
     */
    public function relance(\Swift_Mailer $mailer, int $index)
    {
        $responses = $this->getUser();
        $response = $this->getUser()->getEmail();
        $this->send($mailer, $response, $responses, $index);

        return new Response('ok');
    }

    public function send($mailer, $mail, $responses, $index)
    {
        $message = (new \Swift_Message('Hello!'))
        ->setFrom('no-reply@cgofficiel.fr');
        $message->setTo($mail);
        $message
        ->setBody(
            $this->renderView(
                'relance/email'.$index.'.html.twig',
                array('responses' => $responses)
            ),
            'text/html'
        );
        $mailer->send($message);
    }
}