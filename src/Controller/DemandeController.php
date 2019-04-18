<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Commande;
use App\Manager\DemandeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/demande")
 */
class DemandeController extends AbstractController
{
    /**
     * @Route("/new/{commande}", name="new_demande")
     * @IsGranted(\App\Security\Voter\CommandeVoter::PASSER, subject="commande", message="Vous avez déjà passé cette commande")
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
            $demande = $demandeManager->save($form);
            // redirect after save
            return $this->redirectToRoute(
                'demande_recap', 
                [
                    'demande' => $demande->getId()
                ]
            );
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

    /**
     * @Route("/{demande}/recap", name="demande_recap")
     */
    public function recap(Demande $demande)
    {

        return $this->render(
            'demande/resum.html.twig',
            [
                'demande' => $demande,
            ]
        );
    }

    /**
     * @Route("/{id}/dossiers-a-fournir", name="demande_dossiers_a_fournir")
     */
    public function daf(Demande $demande, DemandeManager $demandeManager)
    {
        $daf = $demandeManager->getDossiersAFournir($demande);

        return $this->render('demande/dossiers_a_fournir.html.twig', [
            'demande' => $demande,
            'daf' => $daf,
            'client' => $this->getUser()->getClient(),
        ]);
    }

    /**
     * @route("/{id}/annuler", name="demande_annuler", methods={"DELETE"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function annuler(Request $request, Demande $demande, DemandeManager $demandeManager)
    {
        if ($this->isCsrfTokenValid('demande'.$demande->getId(), $request->request->get('_token'))) {
            $demandeManager->removeDemande($demande);
        }

        return $this->redirectToRoute('demande_list');
    }
}
