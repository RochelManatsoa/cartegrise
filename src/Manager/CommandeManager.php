<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 11:46:01
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-04-18 17:50:32
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
		TokenStorageInterface $tokenStorage 
	)
	{
		$this->tmsClient = $tmsClient;
		$this->em = $em;
		$this->sessionManager = $sessionManager;
		$this->tokenStorage = $tokenStorage;
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
	public function editer(Commande $commande, $type = "Mandat")
	{
		$client = $this->tokenStorage->getToken()->getUser()->getClient();
		$adresse = $client->getClientAdresse();
		$carInfo = $commande->getCarInfo();
		$params = [
			"Demarche" => $commande->getDemarche()->getType(),
			"DateDemarche" => "17/11/2010 12:00:00",
			"Titulaire" => [
				"NomPrenom" => $client->getClientNomPrenom(),
			],
			"Type"     => $type,
			"Acquereur" => [
				"DroitOpposition" => true,
				"Adresse" => [
					"TypeVoie" => $adresse->getTypevoie(),
					"NomVoie" => $adresse->getNom(),
					"CodePostal" => $adresse->getCodepostal(),
					"Ville" => $adresse->getVille(),
					"Pays" => $adresse->getPays(),
				],
				"PersonneMorale" => [
					"RaisonSociale" => "TMS",
					"SocieteCommerciale" =>true,
					//"SIREN" => "123456789", // siren si exist
				]
			],
			"Vehicule" => [
				"VIN" => $carInfo->getVin(),
				"Immatriculation" => $commande->getImmatriculation(),
				"Marque" => $carInfo->getMarque(),
				"CIPresent" => true, // à voir si la carte grise n'est pas en sa possesion
			]
		];

		return $this->tmsClient->editer($params);
	}
}
