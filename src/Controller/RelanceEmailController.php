<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Manager\DemandeManager;
use App\Manager\TaxesManager;
use App\Manager\MailManager;
use App\Entity\DailyFacture;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Swift_Mailer;


/**
 * @Route("/relance")
 */
class RelanceEmailController extends AbstractController
{
    /**
     * @Route("/user_paiment/{day}", name="user_paiment")
     */
    public function user_relance(int $day, DemandeManager $demandeManager, MailManager $mailManager)
    {
        $demandeManager->getUserWithoutSendDocumentInDay($day, $mailManager);

        return new Response('ok');
    }
    /**
     * @Route("/facture/journalier/{dailyFacture}", name="facture_journalier")
     */
    public function facture_journalier(DailyFacture $dailyFacture, DemandeManager $demandeManager,TaxesManager $taxesManager, MailManager $mailManager)
    {
        $date = $dailyFacture->getDateCreate()->format('Y-m-d');
        $start = new \DateTime($date.' 00:00:00');
        $end = new \DateTime($date.' 23:59:59');
        $demandes = $demandeManager->getDailyDemandeFactureLimitate($start, $end);
        $file = $demandeManager->generateDailyFacture($demandes, $start);

        return new BinaryFileResponse($file);
    }
    /**
     * @Route("/user_paiment_with_doc_non_valid/{day}", name="user_paiment")
     */
    public function user_relance_doc_non_valid(int $day, DemandeManager $demandeManager, MailManager $mailManager)
    {
        $demandeManager->getUserWithSendDocumentButNotValidInDay($day, $mailManager);

        return new Response('ok');
    }

    /**
     * @Route("/email/{index}", name="relance_email_1")
     */
    public function relance(Swift_Mailer $mailer, int $index)
    {
        $responses = $this->getUser();
        $response = $this->getUser()->getEmail();
        $this->send($mailer, $response, $responses, $index);

        return new Response('ok');
    }
    /**
     * @Route("/email_test_mandeha", name="email_test_mandeha")
     */
    public function huhu(Swift_Mailer $mailer)
    {
        $this->send($mailer, 'rapaelec@gmail.com', $this->getUser(), 1);

        return new Response('
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Document</title>
        </head>
        <body>
            manaona
        </body>
        </html>
        ');
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