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
        $price = $this->tarifPrestationRepository->find($typeDemarche);
        if($price == null){
            return 0;
        }
        return $price->getPrix();
     }

     public function fraisTotalTreatmentOfCommande(Commande $commande)
     {
        $prestation = $this->fraisTreatmentOfCommande($commande);
        $majoration = $this->taxesManager->getMajoration($commande->getTaxes());

        return $prestation + $majoration;
     }

     public function fraisTotalOfCommande(Commande $commande)
     {
        $fraisTotal = $this->fraisTotalTreatmentOfCommande($commande);
        $taxeTotal = $commande->getTaxes()->getTaxeTotale();

        return $fraisTotal + $taxeTotal;
     }

     public function fraisTotalTreatmentOfCommandeWithTva(Commande $commande)
     {

        return $this->fraisTotalOfCommande($commande) * 1.2;
     }

     public function fraisTotalTva(Commande $commande)
     {

        return $this->fraisTotalOfCommande($commande) * 0.2;
     }

     public function Total(Commande $commande)
     {

         return $this->fraisTotalTreatmentOfCommandeWithTva($commande) + $this->fraisTotalOfCommande($commande);
     }
 }
