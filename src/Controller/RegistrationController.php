<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Manager\UserManager;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register/confirmed",name="redirection_route")
     */

    public function redirectAction(UserManager $userManager)
    {
        $user = $this->getUser();
        $userManager->sendEmailOnRegistration($user);
        if(0 < count($user->getClient()->getCommandes())){
            $lastCommande = $user->getClient()->getCommandes()->last();
            return $this->redirectToRoute('commande_recap', ['commande' => $lastCommande->getId()]);
        }


        return $this->redirectToRoute('home');
    }
}