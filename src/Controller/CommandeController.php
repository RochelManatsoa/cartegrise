<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\Commande;

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
        return $this->render('commande/list.html.twig', [
            "commandes" => $commandes,
        ]);
    }

    /**
     * @route("/{id}/annuler", name="commande_annuler")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function annuler(Request $request, Commande $commande, EntityManagerInterface $em)
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->query->get('_token'))) {
            $client = $this->getUser()->getClient();
            $client->removeCommande($commande);
            $em->flush();
            $this->addFlash('success', "Commande annulée avec succès !");
        }

        return $this->redirectToRoute('commande_list');
    }
}
