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
use App\Entity\{NewTitulaire, AncienTitulaire, Cotitulaires, Ctvo};
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
        //dd($params);
        
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
            $titulaire = [
                "PersonnePhysique" => [
                    "NomPrenom" => $dca->getNouveauxTitulaire()->getNomPrenomTitulaire(),
                    "NomNaissance" => $dca->getNouveauxTitulaire()->getBirthName(),
                    "Prenom" => $dca->getNouveauxTitulaire()->getPrenomTitulaire(),
                    "Sexe" => $dca->getNouveauxTitulaire()->getGenre(),
                    "DateNaissance" => $dca->getNouveauxTitulaire()->getDateN()->format('Y-m-d'),
                    "LieuNaissance" => $dca->getNouveauxTitulaire()->getLieuN(),
                    "DepNaissance" => $dca->getNouveauxTitulaire()->getDepartementN(),
                    "PaysNaissance" => $dca->getNouveauxTitulaire()->getPaysN(),
                    "DroitOpposition" => $dca->getNouveauxTitulaire()->getDroitOpposition()
                ],
                "AncienneAdresse" => [
                    "Numero" => $dca->getAncienAdresse()->getNumero(),
                    "ExtensionIndice" => $dca->getAncienAdresse()->getExtension(),
                    "TypeVoie" => $dca->getAncienAdresse()->getTypevoie(),
                    "NomVoie" => $dca->getAncienAdresse()->getNom(),
                    "LieuDit" => $dca->getAncienAdresse()->getLieudit(),
                    "EtageEscAppt" => $dca->getAncienAdresse()->getAdprecision(),
                    "Complement" => $dca->getAncienAdresse()->getComplement(),
                    "CodePostal" => $dca->getAncienAdresse()->getCodepostal(),
                    "Ville" => $dca->getAncienAdresse()->getVille(),
                    "Pays" => $dca->getAncienAdresse()->getPays() === null ? "France" : $dca->getAncienAdresse()->getPays(),
                ],
                "NouvelleAdresse" => [
                    "Numero" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getNumero(),
                    "ExtensionIndice" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getExtension(),
                    "TypeVoie" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getTypevoie(),
                    "NomVoie" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getNom(),
                    "LieuDit" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getLieudit(),
                    "EtageEscAppt" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getAdprecision(),
                    "Complement" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getComplement(),
                    "CodePostal" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getCodepostal(),
                    "Ville" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getVille(),
                    "Pays" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getPays() === null ? "France" : $dca->getAncienAdresse()->getPays(),                        
                ],
            ];
        } elseif ( "mor" === $dca->getNouveauxTitulaire()->getType()) {
            $titulaire = [
                "PersonneMorale" =>[
                    "RaisonSociale" => $dca->getNouveauxTitulaire()->getRaisonSociale(),
                    "SocieteCommerciale" => $dca->getNouveauxTitulaire()->getSocieteCommerciale(),
                    "SIREN" => $dca->getNouveauxTitulaire()->getSiren()
                ],
                "AncienneAdresse" => [
                    "Numero" => $dca->getAncienAdresse()->getNumero(),
                    "ExtensionIndice" => $dca->getAncienAdresse()->getExtension(),
                    "TypeVoie" => $dca->getAncienAdresse()->getTypevoie(),
                    "NomVoie" => $dca->getAncienAdresse()->getNom(),
                    "LieuDit" => $dca->getAncienAdresse()->getLieudit(),
                    "EtageEscAppt" => $dca->getAncienAdresse()->getAdprecision(),
                    "Complement" => $dca->getAncienAdresse()->getComplement(),
                    "CodePostal" => $dca->getAncienAdresse()->getCodepostal(),
                    "Ville" => $dca->getAncienAdresse()->getVille(),
                    "Pays" => $dca->getAncienAdresse()->getPays() === null ? "France" : $dca->getAncienAdresse()->getPays(),
                ],
                "NouvelleAdresse" => [
                    "Numero" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getNumero(),
                    "ExtensionIndice" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getExtension(),
                    "TypeVoie" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getTypevoie(),
                    "NomVoie" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getNom(),
                    "LieuDit" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getLieudit(),
                    "EtageEscAppt" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getAdprecision(),
                    "Complement" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getComplement(),
                    "CodePostal" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getCodepostal(),
                    "Ville" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getVille(),
                    "Pays" => $dca->getNouveauxTitulaire()->getAdresseNewTitulaire()->getPays() === null ? "France" : $dca->getAncienAdresse()->getPays(),                        
                ],
            ];
        }

        $params = ["Lot" => [
			"Demarche" => [
				$commande->getDemarche()->getType() => [
                    'ID' => $commande->getTmsId()? $commande->getTmsId() :'',
					'TypeDemarche' => $commande->getDemarche()->getType(),
					"DateDemarche" => $now->format('Y-m-d H:i:s'),
                    "Titulaire" => $titulaire,
					"Vehicule" => [
						"VIN" => $carInfo->getVin(),
                        "Immatriculation" => $commande->getImmatriculation(),
						"Marque" => $carInfo->getMarque(),
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

        if ( "phy" === $dup->getTitulaire()->getType() ){
            $titulaire = [
                "NomPrenom" => $dup->getTitulaire()->getNomprenom(),
                "DroitOpposition" => false,
            ];
        }else{
            $titulaire = [
                "RaisonSocial" => $dup->getTitulaire()->getRaisonsociale(),
                "DroitOpposition" => false,
            ];
        }

        $params = ["Lot" => [
			"Demarche" => [
				$commande->getDemarche()->getType() => [
                    'ID' => $commande->getTmsId()? $commande->getTmsId() :'',
					'TypeDemarche' => $commande->getDemarche()->getType(),
					"DateDemarche" => $now->format('Y-m-d H:i:s'),
                    "MotifDuplicata" => $dup->getMotifDemande(),
                    "CTVOouDC" => false,
                    "Titulaire" => $titulaire,
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
        $carInfo = $commande->getCarInfo();
		$now = new \DateTime();
        $ctvo = $commande->getDemande()->getCtvo();
        $adresse = $ctvo->getAcquerreur()->getAdresseNewTitulaire();
        $cotitulaireParams ["Cotitulaire"]= [];

        // check if persone moral or not: 
            if (NewTitulaire::TYPE_PERS_MORALE == $ctvo->getAcquerreur()->getType()) {
                $acquerreur =[
                    "PersoneMorale" => [
                        "RaisonSociale" => $ctvo->getAcquerreur()->getSocieteCommerciale(),
                        "SocieteCommerciale" => true,
                        "SIREN" => $ctvo->getAcquerreur()->getSiren() !== null ? $ctvo->getAcquerreur()->getSiren() : null,
                    ],
                    "Adresse" => [
                        "Numero" => $adresse->getNumero(),
                        "ExtensionIndice" => $adresse->getExtension(),
                        "TypeVoie" => $adresse->getTypevoie(),
                        "NomVoie" => $adresse->getNom(),
                        "LieuDit" => $adresse->getLieudit(),
                        "Complement" => $adresse->getComplement(),
                        "BoitePostale" => $adresse->getBoitepostale(),
                        "CodePostal" => $adresse->getCodepostal(),
                        "Ville" => $adresse->getVille(),
                        "Pays" => $adresse->getPays() !== null ? $adresse->getPays() : "France",
                    ],
                    "DroitOpposition" => $ctvo->getAcquerreur()->getDroitOpposition(),
                    "AdresseMail" => '',
                    "Telephone" => '',
                ] ;
            } else {
                $acquerreur =[
                    "PersonnePhysique" => [
                        "Nom" => $ctvo->getAcquerreur()->getNomPrenomTitulaire(),
                        "Prenom" =>$ctvo->getAcquerreur()->getPrenomTitulaire(),
                        "Sexe" => $ctvo->getAcquerreur()->getGenre(),
                        "NomUsage" => $ctvo->getAcquerreur()->getGenre(),
                        "DateNaissance" => $ctvo->getAcquerreur()->getDateN()->format('Y-m-d'),
                        "LieuNaissance" => $ctvo->getAcquerreur()->getLieuN(),
                        "DepNaissance" => $ctvo->getAcquerreur()->getDepartementN(),
                        "PaysNaissance" => $ctvo->getAcquerreur()->getPaysN()!== null ? $ctvo->getAcquerreur()->getPaysN() : "France",
                    ],
                    "Adresse" => [
                        "Numero" => $adresse->getNumero(),
                        "ExtensionIndice" => $adresse->getExtension(),
                        "TypeVoie" => $adresse->getTypevoie(),
                        "NomVoie" => $adresse->getNom(),
                        "LieuDit" => $adresse->getLieudit(),
                        "Complement" => $adresse->getComplement(),
                        "BoitePostale" => $adresse->getBoitepostale(),
                        "CodePostal" => $adresse->getCodepostal(),
                        "Ville" => $adresse->getVille(),
                        "Pays" => $adresse->getPays() !== null ? $adresse->getPays() : "France",
                    ],
                    "DroitOpposition" => $ctvo->getAcquerreur()->getDroitOpposition(),
                    "AdresseMail" => '',
                    "Telephone" => '',
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

        if ($ctvo->countCotitulaire() > 0) {
            foreach ($ctvo->getCotitulaire() as $cotitulaire) {
                if ($cotitulaire->getTypeCotitulaire() === Ancientitulaire::PERSONE_PHYSIQUE){
                    $cotitulaireParams ["Cotitulaire"][]= [
                        "PremierCotitulaire" => false,
                        "PersonnePhysique" => [
                            "Nom" => $cotitulaire->getNomCotitulaires(),
                            "Prenom" => $cotitulaire->getPrenomCotitulaire(),
                            "Sexe" => $cotitulaire->getSexeCotitulaire(),
                        ],
                    ];
                } else {
                    $cotitulaireParams ["Cotitulaire"][]= [
                        "PremierCotitulaire" => false,
                        "PersonneMorale" => [
                            "RaisonSociale" => $cotitulaire->getRaisonSocialCotitulaire()
                        ],
                    ];
                }
            }
            $cotitulaireParams["Cotitulaire"][0]["PremierCotitulaire"] = true;
        }

        if ($ctvo->getCiPresent() !== Ctvo::CI_OK){
            $vehicule = [
                "VIN" => $carInfo->getVin(),
                "Immatriculation" => $commande->getImmatriculation(),
                "D1_Marque" => $carInfo->getMarque(),
                "D2_Version" => $carInfo->getModel(),
                "CIPresent" => true,
                "NumFormule" => $ctvo->getNumeroFormule(),
            ];
        }else{
            $vehicule = [
                "VIN" => $carInfo->getVin(),
                "Immatriculation" => $commande->getImmatriculation(),
                "D1_Marque" => $carInfo->getMarque(),
                "D2_Version" => $carInfo->getModel(),
                "CIPresent" => false,
            ];
        }

        $params = ["Lot" => [
			"Demarche" => [
				$commande->getDemarche()->getType() => [
                    'ID' => '',
					"TypeDemarche" => $commande->getDemarche()->getType(),
					"DateDemarche" => $now->format('Y-m-d H:i:s'),
					"Titulaire" => $titulaire,
					"Acquereur" => $acquerreur,
                    "NbCotitulaires" => $ctvo->countCotitulaire(),
                    "Cotitulaires" => $cotitulaireParams,
					"Vehicule" => $vehicule,
				],
			],
        ]];


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
        $cotitulaireParams ["Cotitulaire"] = [];
        $caractTechParams ["Mention"] = [];

        // check if persone moral or not: 
            if (NewTitulaire::TYPE_PERS_MORALE == $titulaire->getType()) {
                $acquerreur =[
                        "PersoneMorale" => [
                            "RaisonSociale" => $titulaire->getSocieteCommerciale(),
                            "SocieteCommerciale" => true,
                            "SIREN" => $titulaire->getSiren() !== null ? $ctvo->getAcquerreur()->getSiren() : null,
                        ],
						"Adresse" => [
                            "Numero" => $adresse->getNumero(),
                            "ExtensionIndice" => $adresse->getExtension(),
                            "TypeVoie" => $adresse->getTypevoie(),
                            "NomVoie" => $adresse->getNom(),
                            "LieuDit" => $adresse->getLieudit(),
                            "Complement" => $adresse->getComplement(),
                            "BoitePostale" => $adresse->getBoitepostale(),
                            "CodePostal" => $adresse->getCodepostal(),
                            "Ville" => $adresse->getVille(),
                            "Pays" => $adresse->getPays() !== null ? $adresse->getPays() : "France",
                        ],
                        "DroitOpposition" => $titulaire->getDroitOpposition(),
					] ;
            } else {
                $acquerreur =[
                    "PersonnePhysique" => [
                        "Nom" => $titulaire->getNomPrenomTitulaire(),
                        "Prenom" =>$titulaire->getPrenomTitulaire(),
                        "Sexe" => $titulaire->getGenre(),
                        "NomUsage" => null,
                        "DateNaissance" => $titulaire->getDateN()->format('Y-m-d'),
                        "LieuNaissance" => $titulaire->getLieuN(),
                        "DepNaissance" => $titulaire->getDepartementN(),
                        "PaysNaissance" => $titulaire->getPaysN()!== null ? $titulaire->getPaysN() : "France",
                    ],
                    "Adresse" => [
                        "Numero" => $adresse->getNumero(),
                        "ExtensionIndice" => $adresse->getExtension(),
                        "TypeVoie" => $adresse->getTypevoie(),
                        "NomVoie" => $adresse->getNom(),
                        "LieuDit" => $adresse->getLieudit(),
                        "Complement" => $adresse->getComplement(),
                        "BoitePostale" => $adresse->getBoitepostale(),
                        "CodePostal" => $adresse->getCodepostal(),
                        "Ville" => $adresse->getVille(),
                        "Pays" => $adresse->getPays() !== null ? $adresse->getPays() : "France",
                    ],
                    "DroitOpposition" => $titulaire->getDroitOpposition(),
                    ];
            }

            if ($divn->countCaractTech() > 0) {
                foreach ($divn->getCaractTech() as $caractTech) {
                    $caractTechParams ["Mention"][]= [
                        "Code" => $caractTech->getCode(),
                        "Valeur1" => $caractTech->getValeur1(),
                        "Valeur2" => $caractTech->getValeur2(),
                    ];
                }
            }

            if(VehiculeNeuf::TYPE_RECEP_COMMUNAUTAIRE == $car->getType()){
                $vehicule = [
                    "VIN" => $car->getVin(),
                    "D1_Marque" => $car->getD1Marque(),
                    "D2_Version" => $car->getD2Version(),
                    "Communautaire" => [
                        "K_NumRecepCE" => $car->getKNumRecepCe(),
                        "DateReception" => $car->getDateReception()->format('Y-m-d'),
                        "D21_CNIT" => $car->getD21Cenit(),
                        "DerivVP" => $car->getDerivVp(),
                    ],
                    "F1_MMaxTechAdm" => $car->getF2MmaxTechAdm(),
                    "F2_MMaxAdmServ" => $car->getF2MmaxAdmServ(),
                    "G_MMaxAvecAttelage" => $car->getGMmaxAvecAttelage(),
                    "G1_PoidsVide" => $car->getG1PoidsVide(),
                    "J1_Genre" => $car->getJ1Genre(),
                    "J3_Carrosserie" => $car->getJ3Carrosserie(),
                    "S1_NbPlaceAssise" => $car->getS1NbPlaceAssise(),
                    "Z1_Mention1" => $car->getZ1Mention1(),
                    "Z1_Value" => $car->getZ1Value()->format('d-m-Y'),
                    "NbMentions" => $divn->countCaractTech(),
                    "Mentions" => $caractTechParams,
                ];
            }else{
                $vehicule = [
                    "VIN" => $car->getVin(),
                    "D1_Marque" => $car->getD1Marque(),
                    "D2_Version" => $car->getD2Version(),
                    "Nationale" => [
                        "D3_Denomination" => $car->getD3Denomination(),
                        "F3_MMaxAdmEns" => $car->getF3MmaxAdmEns(),
                        "J_CategorieCE" => $car->getJCategorieCe(),
                        "J2_CarrosserieCE" => $car->getJ2CarrosserieCe(),
                        "P1_Cyl" => $car->getP1Cyl(),
                        "P2_PuissKW" => $car->getP2PuissKw(),
                        "P3_Energie" => $car->getP3Energie(),
                        "P6_PuissFiscale" => $car->getP6PuissFiscale(),
                        "Q_RapportPuissMasse" => $car->getQRapportPuissMasse(),
                        "S2_NbPlaceDebout" => $car->getS2NbPlaceDebout(),
                        "U1_NiveauSonore" => $car->getU1NiveauSonore(),
                        "U2_NbTours" => $car->getU2NbTours(),
                        "V7_Co2" => $car->getV7Co2(),
                        "V9_ClasseEnvCE" => $car->getV9ClasseEnvCe(),
                    ],
                    "F1_MMaxTechAdm" => $car->getF2MmaxTechAdm(),
                    "F2_MMaxAdmServ" => $car->getF2MmaxAdmServ(),
                    "G_MMaxAvecAttelage" => $car->getGMmaxAvecAttelage(),
                    "G1_PoidsVide" => $car->getG1PoidsVide(),
                    "J1_Genre" => $car->getJ1Genre(),
                    "J3_Carrosserie" => $car->getJ3Carrosserie(),
                    "S1_NbPlaceAssise" => $car->getS1NbPlaceAssise(),
                    "Z1_Mention1" => $car->getZ1Mention1(),
                    "Z1_Value" => $car->getZ1Value()->format('d-m-Y'),
                    "NbMentions" => $divn->countCaractTech(),
                    "Mentions" => $caractTechParams,
                ];
            }

            if ($divn->countCotitulaire() > 0) {
                foreach ($divn->getCotitulaire() as $cotitulaire) {
                    if ($cotitulaire->getTypeCotitulaire() === Ancientitulaire::PERSONE_PHYSIQUE){
                        $cotitulaireParams ["Cotitulaire"][]= [
                            "PremierCotitulaire" => false,
                            "PersonnePhysique" => [
                                "Nom" => $cotitulaire->getNomCotitulaires(),
                                "Prenom" => $cotitulaire->getPrenomCotitulaire(),
                                "Sexe" => $cotitulaire->getSexeCotitulaire(),
                            ],
                        ];
                    } else {
                        $cotitulaireParams ["Cotitulaire"][]= [
                            "PremierCotitulaire" => false,
                            "PersonneMorale" => [
                                "RaisonSociale" => $cotitulaire->getRaisonSocialCotitulaire()
                            ],
                        ];
                    }
                }
                $cotitulaireParams["Cotitulaire"][0]["PremierCotitulaire"] = true;
            }

            if(CarrosierVehiculeNeuf::PERSONE_PHYSIQUE == $carros->getTypeCarrossier()){
                $carrosier = [
                    "Agrement" => $carros->getAgrement(),
                    "Nom" => $carros->getNomCarrosssier(),
                    "Prenom" => $carros->getPrenomCarrossier(),
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
                    $commande->getDemarche()->getType() => [
                        "ID" => "",
                        "TypeDemarche" => $commande->getDemarche()->getType(),
                        "DateDemarche" => $now->format('Y-m-d h:i'),
                        "Acquereur" => $acquerreur,
                        "NbCotitulaires" => $divn->countCotitulaire(),
                        "Cotitulaires" => $cotitulaireParams,
                        "Vehicule" => $vehicule,
                        "Carrossier" => $carros === null ? $carrosier : null,
                    ]
                ]
            ]
        ]; 

        return $params;
    }
}