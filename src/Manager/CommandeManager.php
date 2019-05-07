<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 11:46:01
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-04-24 22:58:41
 */

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;

use App\Services\Tms\TmsClient;
use App\Entity\Commande;
use App\Manager\SessionManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CommandeManager
{
	public function __construct(
		TmsClient $tmsClient, 
		EntityManagerInterface $em, 
		SessionManager $sessionManager,
		TokenStorageInterface $tokenStorage,
		DocumentTmsManager $documentTmsManager
	)
	{
		$this->tmsClient = $tmsClient;
		$this->em = $em;
		$this->sessionManager = $sessionManager;
		$this->tokenStorage = $tokenStorage;
		$this->documentTmsManager = $documentTmsManager;
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

	/**
	 * get Cerfa
	 */
	public function editer(Commande $commande, $type = "Cerfa")
	{
		$params = $this->documentTmsManager->getParamsByCommande($commande, $type);

		if (false == $params) 
			return $params;
		$result = $this->tmsClient->editer($params);

		return $result->getRawData()->Document;
	}
}
