<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-19 10:20:12 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-04-19 10:54:20
 */
namespace App\Manager;

use App\Entity\Commande;

class StatusManager
{
    public const FIRST_STEP="demande efectué";
    public const SECOND_STEP="paiment efectué";
    public const THIRD_STEP="document remplis";
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