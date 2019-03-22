<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/list", name="commande_list")
     */
    public function listAction(Request $request)
    {
        $commandes = $this->getUser()->getClient()->getCommandes();

        return $this->render(
            "commande/list.html.twig", 
            [
                "commandes" => $commandes,
            ]
        );
    }
}
