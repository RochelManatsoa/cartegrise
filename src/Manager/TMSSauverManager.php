<?php

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
use App\Entity\{NewTitulaire, AncienTitulaire, Cotitulaires};

class TMSSauverManager
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
    /**
     * this funcition is here to send save in commande to tms
     *
     * @param Commande $commande
     * @return void
     */
    public function saveByCommande(Commande $commande)
    {
        $params = $this->getParamsForCommande($commande);
        
        return $this->tmsClient->sauver($params);
    }

    public function getParamsForCommande(Commande $commande)
    {
        $typeDemarche = $commande->getDemarche()->getType();
        switch($typeDemarche) {
            case "DIVN":
                return $this->getParamsForDIVN($commande);
                break;
            case "CTVO":
                return $this->getParamsForCTVO($commande);
                break;
            case "DUP":
                return $this->getParamsForDUP($commande);
                break;
            case "DCA":
                return $this->getParamsForDCA($commande);
                break;
            default :
                die('manaona');
                break;
        }
    }
    public function getParamsForDCA(Commande $commande)
    {
        $client = $commande->getClient();
        $adresse = $client->getClientAdresse();
        $carInfo = $commande->getCarInfo();
		$now = new \DateTime();
        $dca = $commande->getDemande()->getChangementAdresse();
        if ( "phy" === $dca->getNouveauxTitulaire()->getType() ) {
            $physique = [
                "NomPrenom" => $dca->getNouveauxTitulaire()->getNomPrenomTitulaire(),
                "NomNaissance" => $dca->getNouveauxTitulaire()->getBirthName(),
                "Prenom" => $dca->getNouveauxTitulaire()->getPrenomTitulaire(),
                "Sexe" => $dca->getNouveauxTitulaire()->getGenre(),
                "DateNaissance" => $dca->getNouveauxTitulaire()->getDateN()->format('dm-Y'),
                "LieuNaissance" => $dca->getNouveauxTitulaire()->getLieuN(),
                "DroitOpposition" => $dca->getNouveauxTitulaire()->getDroitOpposition(),
            ];
        } elseif ( "mor" === $dca->getNouveauxTitulaire()->getType()) {
            $moral = [
                "RaisonSociale" => $dca->getNouveauxTitulaire()->getRaisonSociale(),
                "SocieteCommerciale" => $dca->getNouveauxTitulaire()->getSocieteCommerciale(),
            ];
        }

        $params = ["Lot" => [
			"Demarche" => [
				$commande->getDemarche()->getType() => [
                    'ID' => $commande->getTmsId()? $commande->getTmsId() :'',
					'TypeDemarche' => $commande->getDemarche()->getType(),
					"DateDemarche" => $now->format('Y-m-d H:i:s'),
                    "Titulaire" => "phy" === $dca->getNouveauxTitulaire()->getType() ? $physique : $moral,
                    "AncienneAdresse" => [
                        "TypeVoie" => $dca->getAncienAdresse()->getTypevoie(),
                        "NomVoie" => $dca->getAncienAdresse()->getNom(),
                        "CodePostal" => $dca->getAncienAdresse()->getCodepostal(),
                        "Ville" => $dca->getAncienAdresse()->getVille(),
                    ],
                    "NouvelleAdresse" => [
                        "TypeVoie" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getTypevoie(),
                        "NomVoie" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getNom(),
                        "CodePostal" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getCodepostal(),
                        "Ville" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getVille(),
                    ],
					"Vehicule" => [
						"VIN" => $carInfo->getVin(),
						"Immatriculation" => $commande->getImmatriculation(),
					],
				],
			],
        ]];
        
        return $params;
    }
    public function getParamsForDUP(Commande $commande)
    {
        $client = $commande->getClient();
        $adresse = $client->getClientAdresse();
        $carInfo = $commande->getCarInfo();
		$now = new \DateTime();
        $dup = $commande->getDemande()->getDuplicata();
        // dd($dup);

        $params = ["Lot" => [
			"Demarche" => [
				$commande->getDemarche()->getType() => [
                    'ID' => $commande->getTmsId()? $commande->getTmsId() :'',
					'TypeDemarche' => $commande->getDemarche()->getType(),
					"DateDemarche" => $now->format('Y-m-d H:i:s'),
                    "MotifDuplicata" => $dup->getMotifDemande(),
                    "DatePerte" => $dup->getDatePerte()->format('Y-m-d H:i:s'),
                    "CTVOouDC" => $dup->getDemandeChangementTitulaire(),
                    "Titulaire" => [
                        "NomPrenom" => $dup->getTitulaire()->getNomprenom(),
                        "RaisonSocial" => $dup->getTitulaire()->getType(),
                        "DroitOpposition" => false,
                    ],
					"Vehicule" => [
						"VIN" => $carInfo->getVin(),
						"Immatriculation" => $commande->getImmatriculation(),
					],
				],
			],
        ]];
        if (!is_null($dup->getDatePerte()))
            $params["Lot"]["Demarche"][$commande->getDemarche()->getType()]["DatePerte"] = $dup->getDatePerte()->format('Y-m-d H:i:s');

        
        return $params;
    }
    public function getParamsForCTVO(Commande $commande)
    {
        $client = $commande->getFirstClient();
        $adresse = $client->getClientAdresse();
        $carInfo = $commande->getCarInfo();
		$now = new \DateTime();
		$ctvo = $commande->getDemande()->getCtvo();

        // check if persone moral or not: 
            if (
                NewTitulaire::TYPE_PERS_MORALE == 
                $commande->getDemande()->getCtvo()->getAcquerreur()->getType()
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

        if ($ctvo->getAncienTitulaire()->getType() == AncienTitulaire::PERSONE_PHYSIQUE)
        {
            $titulaire = [
                        "NomPrenom" => $ctvo->getAncienTitulaire()->getNomprenom(),
                    ];
        } else {
            $titulaire = [
                        "RaisonSociale" => $ctvo->getAncienTitulaire()->getRaisonsociale(),
                    ];
        }





        $params = ["Lot" => [
			"Demarche" => [
				$commande->getDemarche()->getType() => [
                    'ID' => '',
					'TypeDemarche' => $commande->getDemarche()->getType(),
					"DateDemarche" => $now->format('Y-m-d H:i:s'),
					"NbCotitulaires" => $ctvo->countCotitulaire(),
					"Titulaire" => $titulaire,
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
        ]];

        if ($ctvo->countCotitulaire() > 0) {
            $cotitulaireParams = [];
            foreach ($ctvo->getCotitulaire() as $cotitulaire) {
                if ($cotitulaire->getTypeCotitulaire() === Ancientitulaire::PERSONE_PHYSIQUE){
                    $cotitulaireParams[]= [
                        "Nom" => $cotitulaire->getNomCotitulaires(),
                        "Prenom" => $cotitulaire->getPrenomCotitulaire(),
                        "Sexe" => $cotitulaire->getSexeCotitulaire(),
                    ];
                } else {
                    $cotitulaireParams[]= [
                        "RaisonSociale" => $cotitulaire->setRaisonSocialCotitulaire()
                    ];
                }
            }
            $params["Lot"]["Demarche"]["CTVO"]["co-titulaire"] = $cotitulaireParams;
        }

        return $params;
    }

    public function getParamsForDIVN(Commande $commande)
    {
        $demande = $commande->getDemande();
        $acquerreur = $commande->getDemande()->getDivn()->getAcquerreur();
        $adresse = $commande->getDemande()->getDivn()->getAcquerreur()->getAdresseNewTitulaire();
        $cotitulaires = $commande->getDemande()->getDivn()->getCotitulaire();

        $cotitulaire = [];
        foreach ($cotitulaire as $cotitulaires) {
            $cotitulaire[]=[
                "Nom" => $cotitulaire->getNomCotitulaires(),
                "Prenom" => $cotitulaire->getPrenomCotitulaire(),
                "Sexe" => $cotitulaire->getSexeCotitulaire(),
                "RaisonSociale" => $cotitulaire->getRaisonSocialCotitulaire(),
            ];
        }
        
        $params = [
            'DIVN' => [
                "ID" => "",
                "TypeDemarche" => "DIVN",
                "RaisonSociale" => $acquerreur->getRaisonSociale(),
                "SocieteCommerciale" => $acquerreur->getSocieteCommerciale(),
                "Nom" => $acquerreur->getNomPrenomTitulaire(),
                "Prenom" => $acquerreur->getPrenomTitulaire(),
                "Sexe" => "M" == $acquerreur->getGenre()? "M" : "F",
                "DateNaissance" => $acquerreur->getDateN()->format('dm-Y'),
                "LieuNaissance" => $acquerreur->getLieuN(),
                "TypeVoie" => $adresse->getTypevoie(),
                "NomVoie" => $adresse->getNom(),
                "CodePostal" => $adresse->getCodepostal(),
                "Ville" => $adresse->getVille(),
                "NbCotitulaires" => count($cotitulaire),
                "Vehicule" => [
                    
                ]
            ]
        ];
        if (count($cotitulaire) > 0 )
            $params['DIVN']['co-titulaires'] = $cotitulaire;
    }
}