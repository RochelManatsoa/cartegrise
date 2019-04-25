<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-24 01:39:17 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-04-24 10:49:14
 */

 namespace App\Manager;

 use App\Entity\Commande;
 use App\Entity\TypeDemande;
 use App\Entity\NewTitulaire;
 use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
 class DocumentTmsManager
 {
    public function __construct(
		TokenStorageInterface $tokenStorage
	)
	{
		$this->tokenStorage = $tokenStorage;
	}
    public function getParamsByCommande(Commande $commande, $type = "Cerfa")
    {
        // dump($commande->getDemarche()->getType());die;
        switch ($commande->getDemarche()->getType()) {
            case TypeDemande::TYPE_DUP: 
                return $this->getParamDup($commande, $type);
                break;
            case TypeDemande::TYPE_DIVN: 
                return $this->getParamDivn($commande, $type);
                break;
            default:
                return false;
        }
        
    }

    public function getParamDup(Commande $commande, $type = "Cerfa")
    {
        $client = $this->tokenStorage->getToken()->getUser()->getClient();
        $adresse = $client->getClientAdresse();
        $carInfo = $commande->getCarInfo();
        return [
			"Type"     => $type,
			"Demarche" => [
				$commande->getDemarche()->getType() => [
					'TypeDemarche' => $commande->getDemarche()->getType(),
					"MotifDuplicata" => $commande->getDemande()->getDuplicata()->getMotifDemande(),
					"Titulaire" => [
						"DroitOpposition" => true,
						"NomPrenom" => $client->getClientNomPrenom(),
					],
					"Acquereur" => [
						"Adresse" => [
							"TypeVoie" => $adresse->getTypevoie(),
							"NomVoie" => $adresse->getNom(),
							"CodePostal" => $adresse->getCodepostal(),
							"Ville" => $adresse->getVille(),
							"Pays" => $adresse->getPays(),
						],
						"PersonneMorale" => [
							"SocieteCommerciale" =>true,
						]
					],
					"Vehicule" => [
						"VIN" => $carInfo->getVin(),
						"Immatriculation" => $commande->getImmatriculation(),
						"Marque" => $carInfo->getMarque(),
						"CIPresent" => true, // à voir si la carte grise n'est pas en sa possesion
					],
				],
			],
		];
    }

    public function getParamDivn(Commande $commande, $type = "Cerfa")
    {
        $client = $this->tokenStorage->getToken()->getUser()->getClient();
        $adresse = $client->getClientAdresse();
        $carInfo = $commande->getCarInfo();

        // check if persone moral or not: 
            if (
                NewTitulaire::TYPE_PERS_MORALE == 
                $commande->getDemande()->getDivn()->getAcquerreur()->getType()
            ) {
                $acquerreur =[
						"Adresse" => [
							"TypeVoie" => $adresse->getTypevoie(),
							"NomVoie" => $adresse->getNom(),
							"CodePostal" => $adresse->getCodepostal(),
							"Ville" => $adresse->getVille(),
							"Pays" => $adresse->getPays(),
                        ],
                        "PersoneMorale" => [
                            'RaisonSociale' => '',
                            "SocieteCommerciale" =>true,
                        ]
					] ;
            } else {
                $acquerreur =[
						"Adresse" => [
							"TypeVoie" => $adresse->getTypevoie(),
							"NomVoie" => $adresse->getNom(),
							"CodePostal" => $adresse->getCodepostal(),
							"Ville" => $adresse->getVille(),
                            "Pays" => $adresse->getPays(),
                            "Sexe" => "M",
                        ],
                        "PersoneMorale" => [
                            'RaisonSociale' => '',
                            "SocieteCommerciale" =>true,
                            "Sexe" => "M"
                        ]
                    ];
            }

        return [
			"Type"     => $type,
			"Demarche" => [
				$commande->getDemarche()->getType() => [
                    'ID' => '',
					'TypeDemarche' => $commande->getDemarche()->getType(),
					"Titulaire" => [
						"DroitOpposition" => true,
                        "NomPrenom" => $client->getClientNomPrenom(),
					],
					"Acquereur" => $acquerreur,
					"Vehicule" => [
						"VIN" => $carInfo->getVin(),
						"Immatriculation" => $commande->getImmatriculation(),
						"D1_Marque" => $carInfo->getMarque(),
						"D2_Version" => $carInfo->getModel(),
						"CIPresent" => true, // à voir si la carte grise n'est pas en sa possesion
					],
				],
			],
		];
    }

 }
