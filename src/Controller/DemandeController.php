<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\CtvoFormType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/demande")
 */

class DemandeController extends AbstractController
{
    /**
     * @Route("/ctvo", name="ctvo_demande")
     */
    public function ctvo(
        Request $request,
        ObjectManager $manager
    )
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $demande = new Demande();
            $form = $this->createForm(CtvoFormType::class, $demande);
            $ctvoFrom = $form->createView();
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $demande->setDateDemande(new \Datetime())
                        // ->setTypeDemande() ....
                        ;
                $manager->persist($demande);
                // $manager->flush();
                dump($demande);
                // return $this->redirectToRoute('compte');
            }

        return $this->render('demande/ctvo.html.twig', [
            'form' => $ctvoFrom,
        ]);
    }
}
