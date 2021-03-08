<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-18 09:52:09 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-12-23 16:14:44
 */

 namespace App\Manager;

 use App\Manager\TaxesManager;
 use App\Entity\Taxes;
 use App\Entity\Commande;
use App\Entity\GesteCommercial\GesteCommercial;
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
        if($typeDemarche->getType() == "DCA"){
            $date = new \DateTime('2020-09-01 06:00:00'); // date chagement tarif DCA 
            if($commande->getSystempayTransaction() != null && $commande->getSystempayTransaction()->getCreatedAt() < $date){
               return 9.89;
            }
        }
        $price = $this->tarifPrestationRepository->findOneBy(["commande" => $typeDemarche->getId()]);
        if($price == null){
            return 0;
        }
        return $price->getPrix();
     }
     public function fraisTreatmentOfCommandeAvoir(Commande $commande)
     {
        $typeDemarche = $commande->getDemarche();
        $price = $this->tarifPrestationRepository->findOneBy(["commande" => $typeDemarche->getId()]);
        if($commande->getDemande()->getFraisRembourser() !== null || $commande->getFraisRembourser() !== null)
            return $commande->getDemande() === null ? $commande->getFraisRembourser() : $commande->getDemande()->getFraisRembourser();
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
        } elseif (
           $commande->getFraisRembourser() != null
         ) {
           return 0;
        }
        return $price->getTva();
     }
     public function tvaTreatmentOfCommandeAvoir(Commande $commande)
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
        $majoration = 0;
        $prestation = $this->fraisTreatmentOfCommande($commande);
        if ($commande->getTaxes() instanceof Taxes)
         $majoration = $this->taxesManager->getMajoration($commande->getTaxes());

        return $prestation + $majoration;
     }

     public function fraisTotalTreatmentOfCommandeAvoir(Commande $commande)
     {
        $majoration = 0;
        $prestation = $this->fraisTreatmentOfCommandeAvoir($commande);
        if ($commande->getTaxes() instanceof Taxes)
         $majoration = $this->taxesManager->getMajoration($commande->getTaxes());

        return $prestation + $majoration;
     }

     public function fraisTotalTreatmentOfCommandeWithoutMajoration(Commande $commande)
     {
        $prestation = $this->fraisTreatmentOfCommande($commande);

        return $prestation;
     }

     public function fraisTotalTreatmentOfCommandeWithTva(Commande $commande)
     {

        return $this->fraisTotalTreatmentOfCommande($commande);
     }
      
     public function fraisTotalTreatmentOfCommandeWithTvaAvoir(Commande $commande)
     {
        if (
           $commande->getDemande() !== null &&
           $commande->getDemande()->getFraisRembourser() !== null &&
           is_numeric($commande->getDemande()->getFraisRembourser())
        ){
           return $commande->getDemande()->getFraisRembourser();
        } elseif (
           $commande->getFraisRembourser() !== null &&
           is_numeric($commande->getFraisRembourser())
        )
        {
            return $commande->getFraisRembourser();
        }

        return $this->fraisTotalTreatmentOfCommande($commande);
     }

     public function fraisTotalTreatmentOfCommandeWithTvaDaily(Commande $commande)
     {

        return $this->fraisTotalTreatmentOfCommandeWithoutMajoration($commande);
     }

     public function tvaOfFraisTreatment(Commande $commande)
     {
        $tva = $this->tvaTreatmentOfCommande($commande)/100;
        $ttc = 1 + ($this->tvaTreatmentOfCommande($commande)/100);
        return round(($this->fraisTotalTreatmentOfCommande($commande) * ($tva/$ttc)),2 , PHP_ROUND_HALF_DOWN);
     }

     public function tvaOfFraisTreatmentAvoir(Commande $commande)
     {
        if ($commande->getDemande() != null && $commande->getDemande()->getFraisRembourser() !== null) {
           return 0;
        } elseif ($commande->getFraisRembourser() !== null) {
           return 0;
        }
        $tva = $this->tvaTreatmentOfCommande($commande)/100;
        $ttc = 1 + ($this->tvaTreatmentOfCommande($commande)/100);
        return round(($this->fraisTotalTreatmentOfCommande($commande) * ($tva/$ttc)),2 , PHP_ROUND_HALF_DOWN);
     }
     public function tvaOfFraisTreatmentDaily(Commande $commande)
     {
        $tva = $this->tvaTreatmentOfCommande($commande)/100;
        $ttc = 1 + ($this->tvaTreatmentOfCommande($commande)/100);
        return round(($this->fraisTotalTreatmentOfCommandeWithoutMajoration($commande) * ($tva/$ttc)),2 ,PHP_ROUND_HALF_DOWN);
     }

     public function fraisTreatmentWithoutTaxesOfCommande(Commande $commande)
     {
        $tva = 1 + ($this->tvaTreatmentOfCommande($commande)/100);
        return round(($this->fraisTotalTreatmentOfCommande($commande) / $tva),2 , PHP_ROUND_HALF_DOWN);
     }

     public function fraisTreatmentWithoutTaxesOfCommandeAvoir(Commande $commande)
     {
        if ($commande->getDemande() != null && $commande->getDemande()->getFraisRembourser() !== null){
           return $commande->getDemande()->getFraisRembourser();
        } elseif ($commande->getFraisRembourser() !== null){
           return $commande->getFraisRembourser();
        }
        $tva = 1 + ($this->tvaTreatmentOfCommande($commande)/100);
        return round(($this->fraisTotalTreatmentOfCommande($commande) / $tva),2 , PHP_ROUND_HALF_DOWN);
     }

     public function fraisTreatmentWithoutTaxesOfCommandeDaily(Commande $commande)
     {
        $tva = 1 + ($this->tvaTreatmentOfCommande($commande)/100);
        return round(($this->fraisTotalTreatmentOfCommandeWithoutMajoration($commande) / $tva),2 , PHP_ROUND_HALF_DOWN);
     }

     public function total(Commande $commande)
     {
        $taxeTotal = $commande->getTaxes()->getTaxeTotale();

         return $this->fraisTotalTreatmentOfCommandeWithTva($commande) + $taxeTotal;
     }

     public function totalAvoir(Commande $commande)
     {
        $taxeTotal = $commande->getTaxes()->getTaxeTotale();

         return $this->fraisTotalTreatmentOfCommandeWithTvaAvoir($commande) + $taxeTotal;
     }

     public function fraisTotalHTOfCommande(Commande $commande)
     {
        $fraisTotal = $this->fraisTreatmentWithoutTaxesOfCommande($commande);
        $taxeTotal = $commande->getTaxes()->getTaxeTotale();

        return $fraisTotal + $taxeTotal;
     }

     public function fraisTotalHTOfCommandeAvoir(Commande $commande)
     {
        $fraisTotal = $this->fraisTreatmentWithoutTaxesOfCommandeAvoir($commande);
        $taxeTotal = $commande->getTaxes()->getTaxeTotale();

        return $fraisTotal + $taxeTotal;
     }

     public function fraisTotalOfCommande(Commande $commande)
     {
        $fraisTotal = $this->fraisTotalTreatmentOfCommande($commande);
        $taxeTotal = $commande->getTaxes()->getTaxeTotale();

        return $fraisTotal + $taxeTotal;
     }

     public function fraisTreatmentWithoutTaxesOfGesteCommercial(GesteCommercial $gesteCommercial)
     {
        $tva = 1 + ($this->tvaTreatmentOfCommande($gesteCommercial->getCommande())/100);
        return round(($gesteCommercial->getFraisDossier() / $tva),2 , PHP_ROUND_HALF_DOWN);
     }

     public function tvaOfGesteCommercial(Commande $commande)
     {
        $tva = $this->tvaTreatmentOfCommande($commande)/100;
        $ttc = 1 + ($this->tvaTreatmentOfCommande($commande)/100);
        return round(($commande->getGesteCommercial()->getFraisDossier() * ($tva/$ttc)),2 , PHP_ROUND_HALF_DOWN);
     }
 }
