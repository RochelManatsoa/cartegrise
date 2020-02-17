<?php
namespace App\Controller\Crm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\{Security, IsGranted};
use App\Form\Crm\CrmSearchType;
use App\Manager\Crm\Modele\CrmSearch;
use App\Manager\Crm\SearchManager;
use App\Entity\Demande;
use App\Entity\Commande;
use App\Manager\DemandeManager;
use App\Manager\DocumentAFournirManager;
use Symfony\Component\Serializer\SerializerInterface;
use App\Manager\{CommandeManager};
use App\Manager\FraisTreatmentManager;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DashboardController extends AbstractController
{
    /**
     * @Route("dashboard/crm", name="route_crm_home")
     * @IsGranted("ROLE_CRM")
     */
    public function dashboardCrm(Request $request, SearchManager $searchManager)
    {
        $crmSearch = new CrmSearch();
        $form = $this->createForm(CrmSearchType::class, $crmSearch);
        $form->handleRequest($request);
        $results = [];
        if ($form->isSubmitted() && $form->isValid())
        {
            $search = $form->getData();
            $results = $searchManager->search($search);
        }
        
        return $this->render(
            'crm/dashboard.html.twig',
            [
                'form' => $form->createView(),
                'commandes' => $results,
            ]
        );
    }

    /**
     * @Route("dashboard/crm/{demande}/dossier_a_fournir", name="route_crm_dossier_fournir")
     * @IsGranted("ROLE_CRM")
     */
    public function crmDossierAFournir(
        Demande $demande,
        DemandeManager $demandeManager,
        DocumentAFournirManager $documentAFournirManager,
        SerializerInterface $serializerInterface
        )
    {
        $daf = $demandeManager->getDossiersAFournir($demande);
        $realFile = $documentAFournirManager->getDaf($demande);
        $fileSerialized = $serializerInterface->normalize($realFile,'json' , ['groups'=>'file']);

        return $this->render(
            'crm/dossiers_a_fournir.html.twig',
            [
                'demande' => $demande,
                'daf'     => $daf,
                'files'   => $fileSerialized,
            ]
        );
    }

    /**
     * @Route("dasboard/crm/{demande}/recap", name="route_crm_demande_recap")
     * @IsGranted("ROLE_CRM")
     */
    public function crmDemandeRecap(Demande $demande)
    {

        return $this->render('crm/demande_recap.html.twig', ['demande'=>$demande]);
    }

    /**
     * @Route("dasboard/crm/{commande}/commande-recap", name="route_crm_commande_recap")
     * @IsGranted("ROLE_CRM")
     */
    public function crmCommandeRecap(Commande $commande)
    {

        return $this->render('crm/commande_recap.html.twig', ['commande'=>$commande]);
    }
    /**
     * @Route("/payment-commande-crm/{commande}/facture", name="route_crm_payment_facture_commande")
     * @IsGranted("ROLE_CRM")
     */
    public function factureCommande(Commande $commande, FraisTreatmentManager $fraisTreatmentManager, CommandeManager $commandeManager)
    {
        $file = $commandeManager->generateFacture($commande);

        return new BinaryFileResponse($file);
    }
    /**
     * @Route("/payment-demande-crm/{demande}/facture", name="route_crm_payment_facture_demande")
     * @IsGranted("ROLE_CRM")
     */
    public function factureDemande(Demande $demande, FraisTreatmentManager $fraisTreatmentManager, DemandeManager $demandeManager)
    {
        $file = $demandeManager->generateFacture($demande);

        return new BinaryFileResponse($file);
    }
}