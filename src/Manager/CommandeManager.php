<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 11:46:01
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2020-07-27 13:26:38
 */

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;

use App\Services\Tms\TmsClient;
use App\Services\Tms\Response as ResponseTms;
use App\Entity\{Commande, Demande, Facture, DailyFacture, Avoir, Transaction, Client, User, PreviewEmail};
use App\Entity\GesteCommercial\GesteCommercial;
use App\Repository\{CommandeRepository, DailyFactureRepository};
use App\Manager\SessionManager;
use App\Manager\{StatusManager, TMSSauverManager, TransactionManager, TaxesManager, MailManager};
use App\Manager\Tms\TmsManager;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\Systempay\Transaction as SystempayTransaction;
use Twig_Environment as Twig;

class CommandeManager
{
	public function __construct(
		TmsClient $tmsClient, 
		EntityManagerInterface $em, 
		SessionManager $sessionManager,
        Twig $twig,
        CommandeRepository $repository,
        TaxesManager $taxesManager,
        DailyFactureRepository $dailyFactureRepository,
		StatusManager $statusManager,
		TokenStorageInterface $tokenStorage,
		DocumentTmsManager $documentTmsManager,
		SerializerInterface $serializer,
		TMSSauverManager $tmsSaveManager, 
		TransactionManager $transactionManager,
		MailManager $mailManager,
		TmsManager $tmsManager
	)
	{
		$this->tmsClient = $tmsClient;
		$this->em = $em;
		$this->repository = $repository;
		$this->taxesManager = $taxesManager;
		$this->dailyFactureRepository = $dailyFactureRepository;
		$this->sessionManager = $sessionManager;
		$this->statusManager = $statusManager;
		$this->tokenStorage = $tokenStorage;
		$this->documentTmsManager = $documentTmsManager;
		$this->serializer = $serializer;
        $this->twig = $twig;
		$this->tmsSaveManager = $tmsSaveManager;
		$this->transactionManager = $transactionManager;
		$this->mailManager = $mailManager;
		$this->tmsManager = $tmsManager;
	}

	public function checkIfTransactionSuccess(Commande $commande)
    {
        $transaction = $this->transactionManager->findTransactionSuccessByCommand($commande);
        if (!$transaction instanceof Transaction) {

			return false;
		}

		$commande->setTransaction($transaction);
		$this->save($commande);

		return true;
    }

	public function updateEtatDemande()
	{
		$commandes = $this->repository->findAll();
		foreach ($commandes as $commande) {
			if ($commande->getDemande() instanceof Demande) {
				$demande = $commande->getDemande();
				if ($commande->getSaved()){
					$demande->setStatusDoc(Demande::DOC_VALID_SEND_TMS);
					$this->saveDemande($demande);
				} elseif (($demande->getAvoir() instanceof Avoir) && ($demande->getStatusDoc() !== Demande::DOC_VALID_SEND_TMS)) {
					$demande->setStatusDoc(Demande::RETRACT_FORM_WAITTING);
					$this->saveDemande($demande);
				} elseif ($demande->getStatusDoc() === null) {
					$demande->setStatusDoc(Demande::DOC_WAITTING);
					$this->saveDemande($demande);
				}
			}
		}
	}

	public function save(Commande $commande)
	{
		// hydrage sql
		$this->persist($commande);
		// save in database
		$this->flush();
	}
	public function saveDemande(Demande $demande)
	{
		// hydrage sql
		$this->em->persist($demande);
		// save in database
		$this->flush();
	}

	public function flush()
	{
		// save in database
		$this->em->flush();
	}

	public function remove(Commande $commande)
	{
		// save in database
		$this->em->remove($commande);
	}

	public function persist(Commande $commande)
	{
		// hydrage sql
		$this->em->persist($commande);
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
				return $this->getParamToEnvoyer($typeDemarche, $commande, $infosVehicule);
				break;
			case "CTVO":
				return $this->getParamToEnvoyer($typeDemarche, $commande, $infosVehicule);
				break;
			case "DIVN":
				return $this->getParamDivnEnvoyer($commande);
				break;
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
		$type = $this->tmsManager->getTYPE($typeDemarche);
		$Vehicule = [
        	"Immatriculation" => $commande->getImmatriculation(), 
			"Departement" => $commande->getCodePostal(),
			"TypeAchat" => $type
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

	private function getParamToEnvoyer($typeDemarche, Commande $commande, $infosVehicule)
	{
		$genre = $this->tmsManager->getGENRE($infosVehicule->Genre);
		$ptca = $this->tmsManager->getPTCA($infosVehicule->PoidsVide);
		$energie = $this->tmsManager->getENERGIE($infosVehicule->Energie);
		$puissance = $infosVehicule->PuissFisc ? $infosVehicule->PuissFisc : 0;
		if ($typeDemarche ==="CTVO")
			$typeDemarche = "VOF";
        $ECG = [
        	"ID" => "", 
			"TypeDemarche" => "ECG",
			"TypeECG" => [
				$typeDemarche => [
					"Vehicule" => [
						"Puissance" => $puissance,
						"Immatriculation" => $commande->getImmatriculation(), 
						"Departement" => $commande->getCodePostal(),
						"Genre" =>$genre,
						"Energie" =>$energie,
						"DateMEC" =>$infosVehicule->DateMec,
						"PTAC" => $ptca,
						"CO2" => $infosVehicule->CO2,
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

	public function getParamDivnEnvoyer(Commande $commande)
	{
		$divnInit = $commande->getDivnInit();
		// $taxes = $commande->getTaxes();
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

		return $params;
	}
	

	public function tmsSauver(Commande $commande)
	{
        $this->em->persist($commande);
		$this->sessionManager->addArraySession(SessionManager::IDS_COMMANDE, [$commande->getId()]);
		$responseSave = $this->tmsSaveManager->saveByCommande($commande);
		$response = $responseSave->getRawData();
		$typeDemarche = $commande->getDemarche()->getType();
		// dd($response);
		// save information of response TMS in commande
		$commande->setTmsId($response->Lot->Demarche->{$typeDemarche}->ID);
		$commande->setTmsSaveResponse(\json_encode($response));
		$this->save($commande);
		// end save information of response TMS in commande
		// open information in tms with id
		// $params = [
		// 	"IDDemarche" => $commande->getTmsId(),
		// 	"TypeDemarche" => $typeDemarche,
		// ];
		// // dd($params);
		// dd($this->tmsClient->ouvrir($params));
		// end open information in tms
		
		return $responseSave;
	}

	public function tmsDivnEnvoyer(Commande $commande)
	{
        $this->em->persist($commande);
		$this->sessionManager->addArraySession(SessionManager::IDS_COMMANDE, [$commande->getId()]);
        $params = $this->getParamEnvoyer('DIVN', $commande, null);
        
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

	public function checkPayment(Commande $commande)
    {
        // if (!$demande->getTransaction() instanceof Transaction) {
            $transaction = $this->transactionManager->init();
            $commande->setTransaction($transaction);
            $transaction->setCommande($commande);
            $this->save($commande);
        // } 
	}

	public function migrateFacture(Commande $commande)
    {
		$facture = is_null($commande->getFacture()) ? new Facture() : $commande->getFacture();
		$infosFacture = $commande->getInfosFacture();
        $facture->setTypePerson($infosFacture->getTypePerson());
        $facture->setSocialReason($infosFacture->getSocialReason());
		$facture->setName($infosFacture->getName());
		$facture->setFirstName($infosFacture->getFirstName());
		$facture->setAdresse($infosFacture->getAdresse());
		$commande->setFacture($facture);
		$facture->setCommande($commande);
		$this->em->persist($facture);
		$this->save($commande);
    }

	public function simulateTransaction(Commande $commande)
    {
		$transaction = new Transaction();
		$commande->setTransaction($transaction);
		$transaction->setCommande($commande);
		$transaction->setStatus('00');
		$this->save($commande);
    }

    public function generateFacture(Commande $commande)
    {
		$this->checkIfTransactionSuccess($commande);
        $folder = $commande->getGeneratedCerfaPath();
        $file = $commande->getGeneratedFacturePathFile();
        // create directory
        if (!is_dir($folder)) mkdir($folder, 0777, true);
        // end create file 
        // get facture if not exist
        // if (!is_file($file)) { // attente de finalité du process
            $snappy = new Pdf('/usr/local/bin/wkhtmltopdf');
            $filename = "Facture";
            $html = $this->twig->render("payment/facture.pdf.twig", ['commande' => $commande]);
            $output = $snappy->getOutputFromHtml($html);
            
            $filefinal = file_put_contents($file, $output);
        // }
        
        return $file;
	}

    public function getDailyCommandeFacture(\DateTime $now)
    {
        $dailyFacture = $this->dailyFactureRepository->findOneBy([], ['id' => 'DESC']);
        if (is_object($dailyFacture))
            $commandes = $this->repository->getDailyCommandeFacture($dailyFacture->getDateCreate(),$now);
        else 
            $commandes = $this->repository->getDailyCommandeFacture(null,$now);

        return $commandes;
    }

    public function getDailyCommandeFactureLimitate(\DateTime $start, \DateTime $end)
    {
        $demandes = $this->repository->getDailyCommandeFactureLimitate($start,$end);

        return $demandes;
    }

    public function generateDailyFacture(array $commandes, \DateTime $now)
    {
        $results = [];
        $majorations = [];
        foreach($commandes as $commande) {
            $results[$commande->getDemarche()->getNom()][] = $commande;
            $majorations[$this->taxesManager->getMajoration($commande->getTaxes())][] = $commande->getTaxes();
        }
        ksort($majorations);
        $dailyFacture = new DailyFacture();

        $folder = $dailyFacture->getDailyFacturePath();
        $file = $dailyFacture->getDailyFacturePathFile($now);

        // create directory
        if (!is_dir($folder)) mkdir($folder, 0777, true);
        // end create file 
        // get facture if not exist
        $origin = '/Users/rapaelec/Downloads/partage/cgoff/cartegrise/public/';
        // dd(__DIR__.'/../../'.$file);
        // dd(!is_file(__DIR__.'/../../'.$file));
        // if (!is_file($file)) { // attente de finalité du process
            $snappy = new Pdf('/usr/local/bin/wkhtmltopdf');
            $filename = "Facture";
            $html = $this->twig->render('payment/facture_journalier.pdf.twig',
            [
                'results' => $results,
                'date' => $now,
                'majorations' => $majorations,
                'demandes' => $commandes,
            ]);
            $output = $snappy->getOutputFromHtml($html);
            
            $filefinal = file_put_contents($file, $output);
        // }
        
        return $file;
	}
	/**
	 * this funciton allow you to get all command where demande is null
	 */
	public function getCommandeWhoDemandeIsNull()
	{
		return $this->repository->findBy(['demande' => null], ['id'=>'DESC']);
	}
	/**
	 * function to retract with commande payed
	 *
	 * @param Commande $commande
	 * @return void
	 */
	public function retracter(Commande $commande)
    {
        if (!$commande instanceof Commande)
            return;
        $commande->setStatusTmp(Commande::RETRACT_FORM_WAITTING);
        $this->save($commande);
    }
	/**
	 * function to retract with commande payed
	 *
	 * @param Commande $commande
	 * @return void
	 */
	public function retracterSecond(Commande $commande)
    {
        if (!$commande instanceof Commande)
            return;
        $commande->setStatusTmp(Commande::RETRACT_DEMAND);
        $this->save($commande);
    }
	/**
	 * function to refund the command payed
	 *
	 * @param Commande $commande
	 * @return void
	 */
    public function refund(Commande $commande)
    {
        if (!$commande instanceof Commande)
            return;
        $commande->setStatusTmp(Commande::RETRACT_REFUND);
        $this->save($commande);
	}

	public function getTitulaireParams(Commande $commande)
    {
		return [
			'adresse' => !is_null($commande->getInfosFacture()) ? $commande->getInfosFacture()->getAdresse() : ""
		];
	}
	
	public function generateAvoir(Commande &$commande)
    {

		if (is_null($commande->getAvoir())){
            $avoir = new Avoir();
            $commande->setAvoir($avoir);
		}
		
		$commande->setStatusTmp(Commande::RETRACT_FORM_WAITTING);
        $folder = $commande->getGeneratedAvoirCerfaPath();
        $file = $commande->getGeneratedAvoirPathFile();
        $params = $this->getTitulaireParams($commande);
		$params = array_merge(['commande' => $commande], $params);
        // create directory
		if (!is_dir($folder)) mkdir($folder, 0777, true);
		
		
        // // end create file 
        // // save Avoir before generate number
        if(
            !is_null($commande->getAvoir()) &&
            $commande->getAvoir()->getFullPath() != $file
        ) {
            $commande->getAvoir()->setFullPath($file);
            $this->save($commande);
        }
        // // end sav Avoir before generate number
        // // get facture if not exist
        // if (!is_file($file)) { // attente de finalité du process
            $snappy = new Pdf('/usr/local/bin/wkhtmltopdf');
            $filename = "Facture";
            $html = $this->twig->render("avoir/avoir.pdf.twig", $params);
            $output = $snappy->getOutputFromHtml($html);
            
            $filefinal = file_put_contents($file, $output);
		// }
		
        
        return $file;
	}
	
	public function sendEmailFormDemande(Commande $commande)
	{
		$user = $commande->getClient()->getUser();
		$this->mailManager->sendEmail($emails=[$user->getEmail()], 'admin/email/demandeFormulaire.email.twig', "CG Officiel - Démarches Carte Grise en ligne", ['commande'=> $commande]);      
	}

	public function saveSystempay(Commande $commande, SystempayTransaction $transaction)
	{
		if ($commande->getSystempayTransaction() !== null && $commande->getSystempayTransaction() instanceof SystempayTransaction) {
			$prevTransaction = $commande->getSystempayTransaction();
			$prevTransaction->setCommande(null);
			$this->em->persist($prevTransaction);
			$this->em->flush();
		}
		$commande->setSystempayTransaction($transaction);
		$this->save($commande);
	}

	public function find(int $id) {
		return $this->repository->find($id);
	}

    public function sendUserForRelanceAfterpaimentSucces($level = 0)
    {
        $commandes = $this->repository->getCommandesPaidedWithoutDemande($level);
        // dd($commandes);
        $template = 'relance/attenteDeDemande.mail.twig';
        $emails = [];
        foreach ($commandes as $commande)
        {
			$user = $commande->getClient()->getUser();
            $this->mailManager->sendEmail($emails=[$user->getEmail()], $template, "CG Officiel - Démarches Carte Grise en ligne", ['responses'=> $commande]);
            $user->getClient()->setRelanceLevel($level+1);
            $this->em->persist($user);
        }
        $this->em->flush();
        
        return 'sended';
    }

    public function checkServiceClient()
    {
        if ($this->tokenStorage->getToken()->getUser()->getClient()) {
			$commandes = $this->repository->findByCommandeByClient($this->tokenStorage->getToken()->getUser()->getClient());
            $status = false;
            foreach($commandes as $commande){
                $tmpStatus = $commande->getTransaction() != null ? $commande->getTransaction()->getStatus() : "";
				if ($tmpStatus == '00') {
                    $status = true;
                    break;
                } 
			}
            if($status){
				//return "0977423130";
				return "0972760107";
            }
        }

        return "0897010800";
	}
	
	public function generateGesteCommercialPdf(GesteCommercial &$gesteCommercial)
    {
		
		$commande = $gesteCommercial->getCommande();

        $folder = $gesteCommercial->getGeneratedGesteCommercialpdfPath();
        $file = $gesteCommercial->getGeneratedGesteCommercialPathFile();
        $params = $this->getTitulaireParams($commande);
		$params = array_merge(['commande' => $commande, 'gesteCommercial' => $gesteCommercial], $params);
        // create directory
		if (!is_dir($folder)) mkdir($folder, 0777, true);
		
		
        // // end create file 
        // // save Avoir before generate number
        if(
            $gesteCommercial->getFullPath() != $file
        ) {
            $gesteCommercial->setFullPath($file);
            $this->save($commande);
        }
        // // end sav Avoir before generate number
        // // get facture if not exist
        // if (!is_file($file)) { // attente de finalité du process
            $snappy = new Pdf('/usr/local/bin/wkhtmltopdf');
            $filename = "GesteCommercial";
            $html = $this->twig->render("gesteCommercial/gesteCommercial.pdf.twig", $params);
            $output = $snappy->getOutputFromHtml($html);
            
            $filefinal = file_put_contents($file, $output);
		// }
		
        
        return $file;
	}

	public function getUserHaveComandNoPayed()
	{
		return $this->repository->getUserHaveComandNoPayed();
	}
	/**
	 * get all user with transation failed
	 *
	 * @return void
	 */
	public function getUserHaveComandFailedPayed()
	{
		// get all user with transaction failed
		return $this->repository->getUserHaveComandFailedPayed();

	}

	/**
	 * get all user with transation failed
	 *
	 * @return void
	 */
	public function getUserWithoutDemandeButPayed()
	{
		// get all user with transaction failed
		return $this->repository->getUserWithoutDemandeButPayed();

	}

	/**
	 * function to check email and then if immatriculation don't exisf 
	 * for the user we create a notificaiton email to send after 24 h 
	 *
	 * @param Commande $commande
	 * @return void
	 */
	public function generatePreviewEmailRelance(Commande $commande, int $step){
		// get the client and user of order
		$client  = $commande->getClient();
		if (!$client instanceof Client){
			return;
		}
		$user = $client->getUser();
		// return if user is not already set
		if (!$user instanceof User) {
			return;
		}
		// get immatriculation
		$immat = (clone $commande)->getImmatriculation();
		
		// check the immatriculaiton of command
		// get all commandes (ArrayCollection)
		$commandes = $this->repository->getCommandeWithImmatOfUser($user, $immat);
		switch($step) {
			case PreviewEmail::MAIL_RELANCE_DEMARCHE :
				// check if email is already set 
				$tmpPrev = $this->em->getRepository(PreviewEmail::class)->findOneBy(['user' => $commande->getClient()->getUser(), 'immatriculation' => $commande->getImmatriculation()]);
				if ($tmpPrev instanceof PreviewEmail) {
					return;
				}
				// if all command is not payed or not have Demande , then create preview email
				$this->createPreviewEmail($commande, $step);
				break;
			case PreviewEmail::MAIL_RELANCE_PAIEMENT :
				// check if email is already set 
				$tmpPrev = $this->em->getRepository(PreviewEmail::class)->findOneBy(['user' => $commande->getClient()->getUser(), 'immatriculation' => $commande->getImmatriculation()]);
				if ($tmpPrev instanceof PreviewEmail && $tmpPrev->getTypeEmail() >= PreviewEmail::MAIL_RELANCE_PAIEMENT) {
					return;
				}
				// if all command is not payed or not have Demande , then create preview email
				$this->createPreviewEmail($commande, $step);
				break;
			
			case PreviewEmail::MAIL_RELANCE_FORMULAIRE :
				// check if email is already set 
				$tmpPrev = $this->em->getRepository(PreviewEmail::class)->findOneBy(['user' => $commande->getClient()->getUser(), 'immatriculation' => $commande->getImmatriculation()]);
				if ($tmpPrev instanceof PreviewEmail && $tmpPrev->getTypeEmail() >= PreviewEmail::MAIL_RELANCE_FORMULAIRE) {
					return;
				}
				// if all command is not payed or not have Demande , then create preview email
				$this->createPreviewEmail($commande, $step);
				break;

			case PreviewEmail::MAIL_RELANCE_UPLOAD :
				// check if email is already set 
				$tmpPrev = $this->em->getRepository(PreviewEmail::class)->findOneBy(['user' => $commande->getClient()->getUser(), 'immatriculation' => $commande->getImmatriculation()]);
				if ($tmpPrev instanceof PreviewEmail && $tmpPrev->getTypeEmail() >= PreviewEmail::MAIL_RELANCE_UPLOAD) {
					return;
				}
				// if all command is not payed or not have Demande , then create preview email
				$this->createPreviewEmail($commande, $step);
				break;
			
		}
		
		// create the preview email of command
	}

	// private function to create preview email
	private function createPreviewEmail(Commande $commande, int $step) {

		// check if email is already set 
		$tmpPrev = $this->em->getRepository(PreviewEmail::class)->findOneBy(['user' => $commande->getClient()->getUser(), 'immatriculation' => $commande->getImmatriculation()]);
		if ($tmpPrev instanceof PreviewEmail) {
			if ($tmpPrev->getTypeEmail() === $step) {
				return;
			} elseif ($tmpPrev->getTypeEmail() <= $step ) {
				$tmpPrev->setTypeEmail($step);
				$tmpPrev->setStatus(PreviewEmail::STATUS_PENDING);
				$tmpPrev->setCommande($commande);
				$tmpPrev->setSendAt((new \DateTime())->modify("+1 day"));
				// save
				$this->em->persist($tmpPrev);
				$this->em->flush();
				// return
				return;
			}
			return ;
			
		}
		
		$previewEmail = new PreviewEmail();
		// set all component from preview Email:
		$previewEmail->setStatus(PreviewEmail::STATUS_PENDING);
		$previewEmail->setImmatriculation($commande->getImmatriculation());
		$previewEmail->setCommande($commande);
		$previewEmail->setUser($commande->getClient()->getUser());
		$previewEmail->setTypeEmail($step);
		// save the preview Email
		// if not email set , then save preview email
		$this->em->persist($previewEmail);
		$this->em->flush();
	}

	public function countFidelite(Client $client)
	{
		$countFidelite = 0 ;
		
		foreach ($client->getCommandes() as $countCommande) {
			if ($countCommande->getSystempayTransaction() instanceof SystempayTransaction){
				if ($countCommande->getSystempayTransaction()->getStatus() === SystempayTransaction::TRANSACTION_SUCCESS) {
					$countFidelite ++;
				}
			}
		}

		return $countFidelite;
	}

}
