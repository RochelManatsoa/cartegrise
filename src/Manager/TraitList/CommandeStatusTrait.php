<?php

namespace App\Manager\TraitList;
use App\Entity\Commande;

trait CommandeStatusTrait
{
    private $FIRST_STEP="Attente de demande";
    private $SECOND_STEP="Attente de paiement";
    private $THIRD_STEP="Attente de document(s)";
    private $FIRST_STEP_STYLE="danger";
    private $SECOND_STEP_STYLE="warning";
    private $THIRD_STEP_STYLE="info";

    public function getStatusOfCommande(Commande $commande)
    {
        if (
            null !== $commande->getDemande() &&
            null !== $commande->getDemande()->getTransaction() &&
            $commande->getDemande()->getTransaction()->getStatus() == "00"
            ) {
                return 
                [
                    "text" => $this->THIRD_STEP,
                    "style" => $this->THIRD_STEP_STYLE,
                ];
        }
        elseif (
            null !== $commande->getDemande()
        ){
            return 
            [
                "text" => $this->SECOND_STEP,
                "style" => $this->SECOND_STEP_STYLE,
            ];
        }
        else {
            return 
            [
                "text" => $this->FIRST_STEP,
                "style" => $this->FIRST_STEP_STYLE,
            ];
        }
    }
}