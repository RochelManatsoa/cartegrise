<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\{PaymentUtils, PaymentResponseTreatment, StatusTreatment};
use App\Entity\Demande;
use App\Entity\NotificationEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Manager\SessionManager;
use App\Manager\DemandeManager;
use App\Manager\FraisTreatmentManager;
use App\Manager\TransactionManager;
use App\Manager\HistoryTransactionManager;
use App\Manager\NotificationEmailManager;
use Symfony\Component\HttpFoundation\Cookie;
use Knp\Snappy\Pdf;


class PaymentController extends AbstractController
{
    /**
     * @Route("/demande/{demande}/payment", name="payment_demande")
     */
    public function index(Demande $demande)
    {
        
        return $this->render(
            "payment/index.html.twig", 
            ['demande' => $demande]
        );
    }

    /**
     * @Route("/payment/request/{demande}", name="payment_request")
     */
    public function request(
        Demande $demande, 
        PaymentUtils $paymentUtils, 
        ParameterBagInterface $parameterBag, 
        DemandeManager $demandeManager, 
        TransactionManager $transactionManager,
        FraisTreatmentManager $fraisTreatmentManager
    )
    {
        $amount = $fraisTreatmentManager->fraisTotalOfCommande($demande->getCommande());
        $email = $this->getUser()->getEmail();
        $demandeManager->checkPayment($demande);
        $idTransaction = $transactionManager->generateIdTransaction($demande->getTransaction());
        $amount *=100;
        $paramDynamical = [
            'amount' => $amount,
            'customer_email' => $email,
        ];
        $param = $parameterBag->get('payment_params');
        $bin   = $parameterBag->get('payment_binary');
        $param = array_merge($param, $paramDynamical);
        $response = $paymentUtils->request($param, $bin);
        $demande->getTransaction()->setTransactionId($response['transactionId']);
        $transactionManager->save($demande->getTransaction());
        
        return new Response($response['template']);
    }

    /**
     * @Route("/payment/ipn", name="instant_payment_notification")
     */
    public function notification(
        Request $request, 
        SessionManager $sessionManager, 
        \Swift_Mailer $mailer,
        PaymentUtils $paymentUtils,
        ParameterBagInterface $parameterBag, 
        PaymentResponseTreatment $responseTreatment, 
        StatusTreatment $statusTreatment,
        HistoryTransactionManager $historyTransactionManager,
        NotificationEmailManager $notificationManager
    )
    {
        $response = $request->request->get('DATA');
        $responses = $this->getResponse($response, $paymentUtils, $parameterBag, $responseTreatment);
        $adminEmails = $notificationManager->getAllEmailOf(NotificationEmail::PAIMENT_NOTIF);
        // send mail
            $this->sendMail($mailer, $responses, $responses["customer_email"], $adminEmails);
            $this->addHistoryTransaction($responses, $historyTransactionManager);
        // end send mail

        return new Response('ok');
    }

    /**
     * @Route("/payment/success", name="payment_success")
     */
    public function success(
        Request $request,
        PaymentUtils $paymentUtils,
        ParameterBagInterface $parameterBag,
        PaymentResponseTreatment $responseTreatment,
        TransactionManager $transactionManager
    )
    {
        $response = $request->request->get('DATA');
        $responses = $this->getResponse($response, $paymentUtils, $parameterBag, $responseTreatment);
        $transaction = $transactionManager->findByTransactionId($responses["transaction_id"]);

        return $this->render(
                'transaction/transactionResponse.html.twig',
                [
                    'responses' => $responses,
                    'transaction' => $transaction,
                ]
        );
    }

    /**
     * @Route("/payment/cancel", name="payment_cancel")
     */
    public function cancel(
        Request $request,
        PaymentUtils $paymentUtils,
        ParameterBagInterface $parameterBag, 
        PaymentResponseTreatment $responseTreatment
    )
    {
        $response = $request->request->get('DATA');
        $responses = $this->getResponse($response, $paymentUtils, $parameterBag, $responseTreatment);

        return $this->render(
                'transaction/transactionResponse.html.twig',
                [
                    'responses' => $responses,
                    'transaction' => null,
                ]
        );
    }

    /**
     * @Route("/payment/{demande}/facture", name="payment_facture")
     */
    public function facture(Demande $demande, FraisTreatmentManager $fraisTreatmentManager)
    {
        $snappy = new Pdf('/usr/local/bin/wkhtmltopdf');
        $filename = "Facture";
        $html = $this->renderView("payment/facture.html.twig", array(
            "demande"=> $demande,
        ));
        // return new Response($html);
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'=>'application/pdf',
                'Content-disposition'=>'inline; filename="'.$filename.'.pdf"'
            )
        );
    }

    // price with TVA
    private function calculateTOTAL($prix)
    {
        return ($prix) + ($prix * 20 / 100);
    }

    // calculate TVA 20%
    private function calculateTVA($prix)
    {
        return $prix * 20 / 100;
    }

    // to get response
    private function getResponse($response, $paymentUtils, $parameterBag, $responseTreatment)
    {
        $param = $parameterBag->get('payment_params');
        $bin   = $parameterBag->get('payment_binary');
        $return = $paymentUtils->decode($bin['response'], $param['pathfile'], $response);
    
        return $responses = $responseTreatment->getResponse($return);
    }

    //function to send email with response in sherlock treatment
    public function sendMail($mailer, $responses, $mail , $admins = [])
    {
        $this->send($mailer, $mail, $responses);
        $this->send($mailer, $admins, $responses, "chère Admin, ");
    }
    //function to send email unit
    public function send($mailer, $mail, $responses, $adminPrepend='')
    {
            $message = (new \Swift_Message($adminPrepend.'Transaction  n°: ' .$responses["transaction_id"]. ' de ' . $responses["customer_email"] ))
            ->setFrom('no-reply@cgofficiel.fr');
            if ($adminPrepend != '' && is_iterable($mail) && count($mail)>0) {
                $message->setTo(array_shift($mail))
                ->setBcc($mail);
            } else {
                $message->setTo($mail);
            }
            $message
            ->setBody(
                $this->renderView(
                    'email/registration.mail.twig',
                    array('responses' => $responses)
                ),
                'text/html'
            );
            $mailer->send($message);
    }

    public function addHistoryTransaction($responses, HistoryTransactionManager $historyTransactionManager)
    {
        $historyTransactionManager->saveResponseTransaction($responses);
    }
}

