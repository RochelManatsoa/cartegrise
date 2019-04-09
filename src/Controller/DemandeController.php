<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Commande;
use App\Manager\DemandeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/demande")
 */
class DemandeController extends AbstractController
{
    /**
     * @Route("/new/{commande}", name="new_demande")
     */
    public function new(
        Commande        $commande,
        Request         $request,
        DemandeManager  $demandeManager
    )
    {
        $form = $demandeManager->generateForm($commande);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $demandeManager->save($form);
            // redirect after save
            return $this->redirectToRoute('Accueil');
        }

        return new Response($demandeManager->getView($form));
    }

    /**
     * @Route("/list", name="demande_list")
     */
    public function list(DemandeManager $demandeManager)
    {
        return $this->render(
            'demande/list.html.twig',
            [
                'demandes' => $demandeManager->getDemandeOfUser($this->getUser()),
                'client' => $this->getUser()->getClient(),
            ]
        );
    }
}
