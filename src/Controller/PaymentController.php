<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\PaymentUtils;
use App\Entity\Demande;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Manager\SessionManager;
use App\Manager\DemandeManager;
use App\Manager\TransactionManager;
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
        ParameterBagInterface $parameterBag
    )
    {
        $response = $request->request->get('DATA');
        $param = $parameterBag->get('payment_params');
        $bin   = $parameterBag->get('payment_binary');
        $return = $paymentUtils->decode($bin['response'], $param['pathfile'], $response);

        $message = (new \Swift_Message('Hello Email tabory'))
        ->setFrom('rapaelector@gmail.com')
        ->setTo('rapaelec@gmail.com')
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'email/registration.html.twig',
                array('name' => $return)
            ),
            'text/html'
        );

        $mailer->send($message);

        return new Response('ok');
    }

    /**
     * @Route("/payment/success", name="payment_success")
     */
    public function success(Request $request, SessionManager $sessionManager, \Swift_Mailer $mailer)
    {

        return new Response('success');
    }
}
