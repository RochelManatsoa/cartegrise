<?php

namespace App\Controller\Client;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/compte")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/", name="compte")
     */
    public function index(Request $request)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY'))
            return $this->render('client/account/index.html.twig');

        return $this->redirectToRoute('home');
    }
    
}