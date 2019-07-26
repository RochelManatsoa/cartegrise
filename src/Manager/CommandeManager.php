<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 11:46:01
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-07-26 15:35:24
 */

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;

use App\Services\Tms\TmsClient;
use App\Services\Tms\Response as ResponseTms;
use App\Entity\Commande;
use App\Manager\SessionManager;
use App\Manager\StatusManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CommandeManager
{
	public function __construct(
		TmsClient $tmsClient, 
		EntityManagerInterface $em, 
		SessionManager $sessionManager,
		StatusManager $statusManager,
		TokenStorageInterface $tokenStorage,
		DocumentTmsManager $documentTmsManager,
		SerializerInterface $serializer
	)
	{
		$this->tmsClient = $tmsClient;
		$this->em = $em;
		$this->sessionManager = $sessionManager;
		$this->statusManager = $statusManager;
		$this->tokenStorage = $tokenStorage;
		$this->documentTmsManager = $documentTmsManager;
		$this->serializer = $serializer;
	}

	public function save(Commande $commande)
	{
		// hydrage sql
		$this->em->persist($commande);
		// save in database
		$this->em->flush();
	}

	public function createCommande()
	{
		$commande = new Commande;
		$commande->setCeerLe(new \DateTime());

		return $commande;
	}

	public function tmsEnvoyer(Commande $commande, ResponseTms $responseTms)
	{
		$infosVehicule = $responseTms->getRawData()->InfoVehicule->Reponse->Positive;
        $this->em->persist($commande);
		$this->sessionManager->addArraySession(SessionManager::IDS_COMMANDE, [$commande->getId()]);
		$typeDemarche = $commande->getDemarche()->getType();
		$params = $this->getParamEnvoyer($typeDemarche, $commande, $infosVehicule);
        
        return $this->tmsClient->envoyer($params);
	}

	private function getParamEnvoyer($typeDemarche, Commande $commande, $infosVehicule)
	{
		switch($typeDemarche) {
			case "DUP":
				return $this->getParamDupEnvoyer($typeDemarche, $commande, $infosVehicule);
				break;
			case "CTVO":
				return $this->getParamDupEnvoyer($typeDemarche, $commande, $infosVehicule);
				break;
			// case "DCA":
			// 	return $this->getParamDCAEnvoyer($typeDemarche, $commande, $infosVehicule);
			// 	break;
			default:
				return $this->getParamDefaultEnvoyer($typeDemarche, $commande, $infosVehicule);
				break;
		}
	}

	private function getParamDCAEnvoyer($typeDemarche, $commande, $infosVehicule)
	{
		$Vehicule = [
			"Immatriculation" => $commande->getImmatriculation(),
			"Departement" => $commande->getCodePostal(),
			"VIN" => $infosVehicule->VIN,
		];
		
		$DateDemarche = date('Y-m-d H:i:s');
        $DCA = [
        	"ID" => "", 
        	"TypeDemarche" => "DCA", 
			"DateDemarche" => $DateDemarche,
			"Titulaire" => [
				"RaisonSociale" => false,
				"SocieteCommerciale" => false,
			],
			"Vehicule" => $Vehicule,
		];
        $Demarche = ["DCA" => $DCA];
        $Lot = ["Demarche" => $Demarche];
        $Immat = ["Immatriculation" => $commande->getImmatriculation()];
        $params = ["Lot" => $Lot];
		return $params;
	}

	private function getParamDefaultEnvoyer($typeDemarche, $commande, $infosVehicule)
	{
		$Vehicule = [
        	"Immatriculation" => $commande->getImmatriculation(), 
			"Departement" => $commande->getCodePostal(),
        ];
        $DateDemarche = date('Y-m-d H:i:s');
        $ECG = [
        	"ID" => "", 
        	"TypeDemarche" => "ECGAUTO", 
			"DateDemarche" => $DateDemarche,
			"Vehicule" => $Vehicule,
		];

		$Demarche = ["ECGAUTO" => $ECG];
        $Lot = ["Demarche" => $Demarche];
        $Immat = ["Immatriculation" => $commande->getImmatriculation()];
		$params = ["Lot" => $Lot];
		
		return $params;
	}

	private function getTypeAchat($type) 
	{
		$responses = [
			'DIVN' => 1,
			'CTVO' => 2,
			'DUP' => 3
		];
		if (isset($responses[$type]))
			return $responses[$type];
		return null;
	}

	private function getParamDupEnvoyer($typeDemarche, Commande $commande, $infosVehicule)
	{
		// to get info for C02, ptac and Energy
		$paramsAuto = $this->getParamDefaultEnvoyer($typeDemarche, $commande, $infosVehicule);
		$infosAutoDefault = $this->tmsClient->envoyer($paramsAuto);
		$infosAutoDefaultResult = $infosAutoDefault->getRawData()->Lot->Demarche->ECGAUTO->Reponse->Positive;
		// end get info for C02, ptac and Energy
		if ($typeDemarche ==="CTVO")
			$typeDemarche = "VOF";
        $ECG = [
        	"ID" => "", 
			"TypeDemarche" => "ECG",
			"TypeECG" => [
				$typeDemarche => [
					"Vehicule" => [
						"Immatriculation" => $commande->getImmatriculation(), 
						"Departement" => $commande->getCodePostal(),
						"Puissance" => $infosVehicule->PuissFisc,
						"Genre" =>$infosAutoDefaultResult->Genre,
						"Energie" =>$infosAutoDefaultResult->Energie,
						"DateMEC" =>$infosVehicule->DateMec,
						"PTAC" => $infosAutoDefaultResult->PTAC,
						"CO2" => $infosAutoDefaultResult->CO2,
						"TypeVehicule" => 1, // see how to integrate
						"Collection" => false,
						"PremiereImmat" => false,
					]
				]
			],
		];
        $Demarche = ['ECG' => $ECG];
        $Lot = ["Demarche" => $Demarche];
        $Immat = ["Immatriculation" => $commande->getImmatriculation()];
		$params = ["Lot" => $Lot];

		return $params;
	}
	

	public function tmsSauver(Commande $commande)
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
        
        return $this->tmsClient->sauver($params);
	}

	public function tmsDivnEnvoyer(Commande $commande)
	{
        $this->em->persist($commande);
		$this->sessionManager->addArraySession(SessionManager::IDS_COMMANDE, [$commande->getId()]);
		$divnInit = $commande->getDivnInit();
		

        $Vehicule = [
        	"TypeVehicule" => 2, 
			"Departement" => $commande->getCodePostal(),
			"Puissance" => $divnInit->getPuissanceFiscale(),
			"Genre" => $divnInit->getGenre(),
			"PTAC" => 1,
			"Energie" => $divnInit->getEnergie(),
			"Departement" => $divnInit->getDepartment(),
			"TypeAchat" => 1,
			"PremiereImmat" => 1,
			"CO2" => $divnInit->getTauxDeCo2(),
			"Collection" => false,
        ];
        $DateDemarche = date('Y-m-d H:i:s');

        $ECG = [
        	"ID" => "", 
        	"TypeDemarche" => "ECG",
			"TypeECG" => [
				"VN" => [
					"Vehicule" => $Vehicule
				]
			],
		];

        $Demarche = ["ECG" => $ECG];
        $Lot = ["Demarche" => $Demarche];
        $Immat = ["Immatriculation" => $commande->getImmatriculation()];
		$params = ["Lot" => $Lot];
        
        return $this->tmsClient->envoyer($params);
	}

	public function tmsDivnSauver(Commande $commande)
	{
        $this->em->persist($commande);
		$this->sessionManager->addArraySession(SessionManager::IDS_COMMANDE, [$commande->getId()]);
		$divnInit = $commande->getDivnInit();
		

        $Vehicule = [
        	"TypeVehicule" => 1, 
			"Departement" => $commande->getCodePostal(),
			"Puissance" => $divnInit->getPuissanceFiscale(),
			"Genre" => $divnInit->getGenre(),
			"PTAC" => 1,
			"Energie" => $divnInit->getEnergie(),
			"Departement" => $divnInit->getDepartment(),
			"TypeAchat" => 1,
			"PremiereImmat" => 1,
			"CO2" => $divnInit->getTauxDeCo2(),
			"Collection" => false,
        ];
        $DateDemarche = date('Y-m-d H:i:s');

        $ECG = [
        	"ID" => "", 
        	"TypeDemarche" => "ECG", 
        	"DateDemarche" => $DateDemarche,
        	"Vehicule" => $Vehicule
		];

        $Demarche = ["ECG" => $ECG];
        $Lot = ["Demarche" => $Demarche];
        $Immat = ["Immatriculation" => $commande->getImmatriculation()];
		$params = ["Lot" => $Lot];
        
        return $this->tmsClient->sauver($params);
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

	/**
	 * function to get status
	 */
	public function getStatus(Commande $commande)
	{
		return $this->statusManager->getStatusOfCommande($commande);
	}
}
