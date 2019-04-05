<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\PaymentUtils;
use App\Entity\Demande;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

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
    public function request(Demande $demande, PaymentUtils $paymentUtils, ParameterBagInterface $parameterBag)
    {
        $taxes = $demande->getCommande()->getTaxes()->getTaxeTotale();
        $taxes *=100;
        $paramDynamical = [
            'amount' => $taxes,
            'customer_email' => 'joachim.peetroons@ynover.com',
        ];
        $param = $parameterBag->get('payment_params');
        $bin   = $parameterBag->get('payment_binary');
        $param = array_merge($param, $paramDynamical);
        
        return new Response($paymentUtils->request($param, $bin));
    }
}
