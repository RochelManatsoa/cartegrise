<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-18 09:52:09 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-04-18 10:12:49
 */

 namespace App\Manager;

 use App\Manager\TaxesManager;
 use App\Entity\Commande;
 use App\Repository\TarifsPrestationsRepository;

 class FraisTreatmentManager
 {
     private $taxesManager;
     private $tarifPrestationRepository;

     public function __construct(
         TaxesManager $taxesManager,
         TarifsPrestationsRepository $tarifPrestationRepository
     )
     {
        $this->taxesManager = $taxesManager;
        $this->tarifPrestationRepository = $tarifPrestationRepository;
     }
     public function fraisTreatmentOfCommande(Commande $commande)
     {
        $typeDemarche = $commande->getDemarche();
        $price = $this->tarifPrestationRepository->findOneBy(["commande" => $typeDemarche->getId()]);
        if($price == null){
            return 0;
        }
        return $price->getPrix();
     }
     public function tvaTreatmentOfCommande(Commande $commande)
     {
        $typeDemarche = $commande->getDemarche();
        $price = $this->tarifPrestationRepository->findOneBy(["commande" => $typeDemarche->getId()]);
        if($price == null){
            return 0;
        }
        return $price->getTva();
     }

     public function fraisTotalTreatmentOfCommande(Commande $commande)
     {
        $prestation = $this->fraisTreatmentOfCommande($commande);
        $majoration = $this->taxesManager->getMajoration($commande->getTaxes());

        return $prestation + $majoration;
     }

     public function fraisTotalTreatmentOfCommandeWithTva(Commande $commande)
     {

        return round(($this->fraisTotalTreatmentOfCommande($commande)), 2);
     }

     public function tvaOfFraisTreatment(Commande $commande)
     {
        $tva = $this->tvaTreatmentOfCommande($commande)/100;
        $ttc = 1 + ($this->tvaTreatmentOfCommande($commande)/100);
        return round(($this->fraisTotalTreatmentOfCommande($commande) * ($tva/$ttc)), 2);
     }

     public function fraisTreatmentWithoutTaxesOfCommande(Commande $commande)
     {
        $tva = 1 + ($this->tvaTreatmentOfCommande($commande)/100);
        return round(($this->fraisTotalTreatmentOfCommande($commande) / $tva), 2);
     }

     public function total(Commande $commande)
     {
        $taxeTotal = $commande->getTaxes()->getTaxeTotale();

         return $this->fraisTotalTreatmentOfCommandeWithTva($commande) + $taxeTotal;
     }


     public function fraisTotalHTOfCommande(Commande $commande)
     {
        $fraisTotal = $this->fraisTreatmentWithoutTaxesOfCommande($commande);
        $taxeTotal = $commande->getTaxes()->getTaxeTotale();

        return $fraisTotal + $taxeTotal;
     }

     public function fraisTotalOfCommande(Commande $commande)
     {
        $fraisTotal = $this->fraisTotalTreatmentOfCommande($commande);
        $taxeTotal = $commande->getTaxes()->getTaxeTotale();

        return $fraisTotal + $taxeTotal;
     }
 }
