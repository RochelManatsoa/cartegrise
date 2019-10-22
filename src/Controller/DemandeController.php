<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Commande;
use App\Entity\Divn;
use App\Manager\{DemandeManager, DocumentAFournirManager};
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\DocumentDemande\DemandeDuplicataType;
use App\Form\PaiementType;
use App\Form\VehiculeNeufInfoType;
use App\Entity\File\DemandeDuplicata;
use App\Entity\File\Files;

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
                'espace_client'
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
                'demande' => $demandeManager->getHerLastDemande(),
                'client' => $this->getUser()->getClient(),
            ]
        );
    }

    /**
     * @Route("/espace-client", name="espace_client")
     * @Route("/espace-client/{demande}")
     */
    public function espaceClient(DemandeManager $demandeManager, DocumentAFournirManager $documentAFournirManager, ?Demande $demande=null)
    {
        if (!$demande instanceof Demande) {
            $demande = $demandeManager->getHerLastDemande();
        }
        $fileForm = null;
        $fileType = $documentAFournirManager->getType($demande);
        $files = $documentAFournirManager->getDaf($demande);
        if (!null == $fileType) {
            $fileForm = $this->createForm($fileType, $files);
        }

        return $this->render(
            'demande/list.html.twig',
            [
                'demande' => $demande,
                'client' => $this->getUser()->getClient(),
                'form'      => is_null($fileForm) ? null :$fileForm->createView(),
                "files"     => $files,
            ]
        );
    }

    /**
     * @Route("/{demande}/recap", name="demande_recap")
     */
    public function recap(Demande $demande, Request $request)
    {
        $formCGV = $this->createForm(PaiementType::class, null);
        $formCGV->handleRequest($request);
        if($formCGV->isSubmitted() && $formCGV->isValid()){

            return $this->redirectToRoute('payment_demande', ['demande' => $demande->getId()]);
        }
        return $this->render(
            'demande/resum.html.twig',
            [
                'demande' => $demande,
                'formCGV'    => $formCGV->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}/dossiers-a-fournir", name="demande_dossiers_a_fournir")
     */
    public function daf
    (
        Demande $demande, 
        DemandeManager $demandeManager, 
        DocumentAFournirManager $documentAFournirManager,
        Request $request
    )
    {
        $pathCerfa = $demandeManager->generateCerfa($demande);
        $daf = $demandeManager->getDossiersAFournir($demande, $pathCerfa);
        $files = $documentAFournirManager->getDaf($demande);
        $fileType = $documentAFournirManager->getType($demande);
        $path = $demande->getUploadPath();
        $fileForm = null;
        if (!null == $fileType) {
            $fileForm = $this->createForm($fileType, $files);
            $fileForm->handleRequest($request);

            if ($fileForm->isSubmitted() && $fileForm->isValid()) {
                $documentAFournirManager->handleForm($fileForm, $path)->save($fileForm);
            }
        }

        return $this->render('demande/dossiers_a_fournir.html.twig', [
            'demande'   => $demande,
            'daf'       => $daf,
            'pathCerfa' => $pathCerfa,
            'form'      => is_null($fileForm) ? null :$fileForm->createView(),
            'client'    => $this->getUser()->getClient(),
            "files"     => $files,
        ]);
    }

    /**
     * @route("/{id}/annuler", name="demande_annuler", methods={"DELETE"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function annuler(Request $request, Demande $demande, DemandeManager $demandeManager, EntityManagerInterface $em)
    {
        if ($this->isCsrfTokenValid('demande'.$demande->getId(), $request->request->get('_token'))) {
            // $demandeManager->removeDemande($demande);
            $client = $this->getUser()->getClient();
            $client->removeCommande($demande->getCommande());
            $em->flush();
            $this->addFlash('success', "Demande annulée avec succès !");
        }

        return $this->redirectToRoute('demande_list');
    }

    /**
     * @Route("/new/{divn}/divn", name="divn_demande")
     */
    public function divnInfoVehicule(
        Divn        $divn,
        Request         $request,
        ObjectManager   $manager
    )
    {
        $form = $this->createForm(VehiculeNeufInfoType::class, $divn);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $divn = $form->getData();
            if (!$divn instanceof Divn)
                return;
            $manager->persist($divn);
            $manager->flush();
            // redirect after save
            return $this->redirectToRoute(
                'demande_dossiers_a_fournir', 
                [
                    'id' => $divn->getDemande()->getId()
                ]
            );
        }

        return $this->render('demande/infoVehiculeNeuf.html.twig', [
            'form' => $form->createView(),
            'commande' => $divn->getDemande()->getCommande()
        ]);
    }
}
