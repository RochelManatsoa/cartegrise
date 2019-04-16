<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 11:46:01
 * @Last Modified by:   stephan
 * @Last Modified time: 2019-04-15 12:16:58
 */

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;

use App\Services\Tms\TmsClient;
use App\Entity\Commande;
use App\Manager\SessionManager;

class CommandeManager
{
	public function __construct(TmsClient $tmsClient, EntityManagerInterface $em, SessionManager $sessionManager)
	{
		$this->tmsClient = $tmsClient;
		$this->em = $em;
		$this->sessionManager = $sessionManager;
	}

	public function createCommande()
	{
		$commande = new Commande;
		$commande->setCeerLe(new \DateTime());

		return $commande;
	}

	public function tmsEnvoyer(Commande $commande)
	{
        $this->em->persist($commande);
        $this->sessionManager->addArraySession(SessionManager::IDS_COMMANDE, [$commande->getId()]);

        $Vehicule = [
        	"Immatriculation" => $commande->getImmatriculation(), 
        	"Departement" => $commande->getCodePostal(),
        ];
        $DateDemarche = date('Y-m-d H:i:s');

        $ECG = [
        	"ID" => "", 
        	"TypeDemarche" => "ECGAUTO", 
        	"DateDemarche" => $DateDemarche,
        	"Vehicule" => $Vehicule
		];

        $Demarche = ["ECGAUTO" => $ECG];
        $Lot = ["Demarche" => $Demarche];
        $Immat = ["Immatriculation" => $commande->getImmatriculation()];
        $params = ["Lot" => $Lot];
        
        return $this->tmsClient->envoyer($params);
	}

	/**
	 * Get information by immatriculation
	 */
	public function tmsInfoImmat(Commande $commande)
	{
        $Immat = ["Immatriculation" => $commande->getImmatriculation()];
        
        return $this->tmsClient->infoImmat($Immat);
	}
}