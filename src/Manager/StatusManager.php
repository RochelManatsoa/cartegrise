<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-19 10:20:12 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-04-19 11:14:05
 */
namespace App\Manager;

use App\Entity\Commande;

class StatusManager
{
    public const FIRST_STEP="attente de demande";
    public const SECOND_STEP="attente de paiement";
    public const THIRD_STEP="attente de document";
    public const FIRST_STEP_STYLE="danger";
    public const SECOND_STEP_STYLE="warning";
    public const THIRD_STEP_STYLE="info";

    public function getStatusOfCommande(Commande $commande)
    {
        if (
            null !== $commande->getDemande() &&
            null !== $commande->getDemande()->getTransaction() &&
            $commande->getDemande()->getTransaction()->getStatus() == "00"
            ) {
                return 
                [
                    "text" => $this::THIRD_STEP,
                    "style" => $this::THIRD_STEP_STYLE,
                ];
        }
        elseif (
            null !== $commande->getDemande()
        ){
            return 
            [
                "text" => $this::SECOND_STEP,
                "style" => $this::SECOND_STEP_STYLE,
            ];
        }
        else {
            return 
            [
                "text" => $this::FIRST_STEP,
                "style" => $this::FIRST_STEP_STYLE,
            ];
        }
    }
}