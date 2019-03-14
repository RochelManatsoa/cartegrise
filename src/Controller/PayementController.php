<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PayementController extends AbstractController
{
    /**
     * @Route("/payement", name="payement")
     */
    public function index()
    {
        return $this->render('payement/index.html.twig', [

        ]);
    }
}
