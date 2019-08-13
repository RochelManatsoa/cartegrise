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
use App\Entity\Vehicule\{VehiculeNeuf, CarrosierVehiculeNeuf, CaracteristiqueTechVehiculeNeuf};

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
                        "NumFormule" => $dca->getNumeroFormule(),
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
                        "NumFormule" => $dup->getNumeroFormule(),
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
						"CIPresent" => false, // à voir si la carte grise n'est pas en sa possesion
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
        $divn = $commande->getDemande()->getDivn();
        $titulaire = $divn->getAcquerreur();
        $adresse = $divn->getAcquerreur()->getAdresseNewTitulaire();
        $car = $divn->getVehicule();
        $carros = $divn->getCarrosier();
		$now = new \DateTime();        

        // check if persone moral or not: 
            if (
                NewTitulaire::TYPE_PERS_MORALE == 
                $commande->getDemande()->getdivn()->getAcquerreur()->getType()
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
                            "RaisonSociale" => $titulaire->getRaisonSociale(),
                            "SocieteCommerciale" => $titulaire->getSocieteCommerciale(),
                            "Siren" => $titulaire->getSocieteCommerciale() ? $titulaire->getSiren() : null,
                        ]
					] ;
            } else {
                $acquerreur =[
						"Adresse" => [
							"TypeVoie" => $adresse->getTypevoie(),
							"NomVoie" => $adresse->getNom(),
							"CodePostal" => $adresse->getCodepostal(),
							"Ville" => $adresse->getVille(),
                            "Pays" => $adresse->getPays()
                        ],
                        "PersonePhysique" => [
                            "Nom" => $titulaire->getNomPrenomTitulaire(),
                            "Prenom" => $titulaire->getPrenomTitulaire(),
                            "Sexe" => $titulaire->getGenre(),
                            "DateNaissance" => $titulaire->getDateN()->format('Y-m-d'),
                            "LieuNaissance" => $titulaire->getLieuN()
                        ]
                    ];
            }

            if(VehiculeNeuf::TYPE_RECEP_COMMUNAUTAIRE == $car->getType()){
                $vehicule = [
                    "VIN" => $car->getVin(),
                    "D1_Marque" => $car->getD1Marque(),
                    "D2_Version" => $car->getD2Version(),
                    "DateReception" => $car->getDateReception()->format('Y-m-d'),
                    "D21_CNIT" => $car->getD21Cenit(),
                    "DerivVP" => $car->getDerivVp(),
                    "NbMentions" => $divn->countCaractTech()
                ];
            }else{
                $vehicule = [
                    "VIN" => $car->getVin(),
                    "D1_Marque" => $car->getD1Marque(),
                    "D2_Version" => $car->getD2Version(),
                    "D3_Denomination" => $car->getD3Denomination(),
                    "F1_MMaxTechAdm" => $car->getF2MmaxTechAdm(),
                    "G_MMaxAvecAttelage" => $car->getGMmaxAvecAttelage(),
                    "G1_PoidsVide" => $car->getG1PoidsVide(),
                    "J_CategorieCE" => $car->getJCategorieCe(),
                    "J1_Genre" => $car->getJ1Genre(),
                    "J3_Carrosserie" => $car->getJ3Carrosserie(),
                    "P6_PuissFiscale" => $car->getP6PuissFiscale(),
                    "NbMentions" => $divn->countCaractTech()
                ];
            }

            if(CarrosierVehiculeNeuf::PERSONE_PHYSIQUE == $carros->getTypeCarrossier()){
                $carrosier = [
                    "Agrement" => $carros->getAgrement(),
                    "Nom" => $carros->getNomCarrosssier(),
                    "Prenom" => $carros->getPrenomCarrosssier(),
                    "Justificatifs" => $carros->getJustificatifs()
                ];
            }else{
                $carrosier = [
                    "Agrement" => $carros->getAgrement(),
                    "RaisonSociale" => $carros->getRaisonSocialCarrossier(),
                    "Justificatifs" => $carros->getJustificatifs()
                ];
            }       
            
        
        $params = [
            "Lot" => [
                "Demarche" => [
                    'DIVN' => [
                        "ID" => "",
                        "TypeDemarche" => $commande->getDemarche()->getType(),
                        "DateDemarche" => $now->format('Y-m-d h:i'),
                        "NbCotitulaires" => $divn->countCotitulaire(),
                        "Acquereur" => $acquerreur,
                        "Vehicule" => $vehicule,
                        // "CaracteristiquesTechniquesParticulieres" => $cacart,
                        "Carrossier" => $carrosier
                    ]
                ]
            ]
        ];        
                
        if ($divn->countCotitulaire() > 0) {
            $cotitulaireParams = [];
            foreach ($divn->getCotitulaire() as $cotitulaire) {
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

            $params["Lot"]["Demarche"]["DIVN"]["co-titulaire"] = $cotitulaireParams;
        }

        if ($divn->countCaractTech() > 0) {
            $caractTechParams = [];
            foreach ($divn->getCaractTech() as $caractTech) {
                $caractTechParams[]= [
                    "Code" => $caractTech->getCode(),
                    "Valeur1" => $caractTech->getValeur1(),
                    "Valeur2" => $caractTech->getValeur(),
                ];
            }
            
            // Mentions = Caractéristique technique particulière
            $params["Lot"]["Demarche"]["DIVN"]["Mentions"] = $caractTechParams;
        }

        return $params;
    }
}