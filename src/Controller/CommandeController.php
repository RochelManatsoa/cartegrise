<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\PaiementType;
use App\Entity\Demande;
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

    /**
     * @Route("/{commande}/recap", name="commande_recap")
     */
    public function recap(Commande $commande, Request $request)
    {
        $formCGV = $this->createForm(PaiementType::class, null);
        $formCGV->handleRequest($request);
        if($formCGV->isSubmitted() && $formCGV->isValid()){

            return $this->redirectToRoute('payment_commande', ['commande' => $commande->getId()]);
        }
        return $this->render(
            'commande/resum.html.twig',
            [
                'commande' => $commande,
                'formCGV'    => $formCGV->createView(),
            ]
        );
    }

    /**
     * @Route("/{commande}/paiement", name="commande_recap_paiement")
     */
    public function paiement(Commande $commande)
    {
        return $this->render('commande/paiement.html.twig', [
            'commande' => $commande,
        ]);
    }
}
