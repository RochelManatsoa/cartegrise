<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\{PaymentUtils, PaymentResponseTreatment, StatusTreatment};
use App\Entity\Demande;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Manager\SessionManager;
use App\Manager\DemandeManager;
use App\Manager\TransactionManager;
use App\Manager\HistoryTransactionManager;
use Symfony\Component\HttpFoundation\Cookie;

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
        TransactionManager $transactionManager
    )
    {
        $taxes = $demande->getCommande()->getTaxes()->getTaxeTotale();
        $email = $this->getUser()->getEmail();
        $demandeManager->checkPayment($demande);
        $idTransaction = $transactionManager->generateIdTransaction($demande->getTransaction());
        $taxes *=100;
        $paramDynamical = [
            'amount' => $taxes,
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
        HistoryTransactionManager $historyTransactionManager
    )
    {
        $response = $request->request->get('DATA');
        $responses = $this->getResponse($response, $paymentUtils, $parameterBag, $responseTreatment);
        // send mail
            $this->sendMail($mailer, $responses, $responses["customer_email"], $parameterBag->get('admin_mail'));
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
        PaymentResponseTreatment $responseTreatment
    )
    {
        $response = $request->request->get('DATA');
        $responses = $this->getResponse($response, $paymentUtils, $parameterBag, $responseTreatment);

        return $this->render(
                'transaction/transactionResponse.html.twig',
                array('responses' => $responses)
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
                array('responses' => $responses)
        );
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
        foreach ( $admins as $admin)
        {
            $this->send($mailer, $mail, $responses, "chère Admin, ");
        }
    }
    //function to send email unit
    public function send($mailer, $mail, $responses, $objectPrepend='')
    {
            // $message = (new \Swift_Message($object . ' de '. $responses["customer_email"] . ' ' . $responses["transaction_id"]))
            $message = (new \Swift_Message($objectPrepend.'Transaction  n°: ' .$responses["transaction_id"]. ' de ' . $responses["customer_email"] ))
            ->setFrom('noreply@cgofficiel.fr')
            ->setTo($mail)
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
