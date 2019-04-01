<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Commande;
use App\Entity\Taxes;
use App\Entity\TypeDemande;
use App\Form\DemandeType;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use App\Repository\TaxesRepository;
use App\Repository\DemandeRepository;
use App\Repository\TypeDemandeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Manager\SessionManager;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="Accueil")
     */
    public function accueil(
        Request $request,
        TypeDemandeRepository $demarche,
        ObjectManager $manager,
        TaxesRepository $taxesRepository,
        CommandeRepository $commandeRepository,
        SessionManager $sessionManager
        )
    {

        // dump($this->getUser()->getClient()->getCountDem());die;
        
        $commande = new Commande();
        $type = $demarche->findAll();
        foreach($type as $typeId){
            $defaultType = $demarche->find($typeId->getId());            
            $form = $this->createForm(CommandeType::class, $commande , array(
                'defaultType'=>$defaultType)
            );
            $num = $typeId->getId();
            $tabForm[$num]=$form->createView();
        }

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $ifCommande = $commandeRepository->findOneBy([
                'immatriculation' => $commande->getImmatriculation(),
                'codePostal' => $commande->getCodePostal(),
                'demarche' => $commande->getDemarche(),
            ]);
            $sessionManager->initSession();
            if($ifCommande !== null){
                $recapCommand = $ifCommande;
                $param = $this->getParamHome($recapCommand, $sessionManager, $tabForm);

                return $this->render('home/accueil.html.twig', $param);
            } else {
                $TMS_URL = "http://test.misiv.intra.misiv.fr/wsdl/ws_interface.php?v=2";
                $TMS_CodeTMS = "31-000100";
                $TMS_Login = "JE@n-Y100";
                $TMS_Password = "GY-31@mLA";
                $TMS_Immatriculation = $commande->getImmatriculation();
                $client = new \SoapClient($TMS_URL);
                $Ident = array("CodeTMS"=>$TMS_CodeTMS, "Login"=>$TMS_Login, "Password"=>$TMS_Password);
                $type_demarche = $commande->getDemarche();
                $code_postal = $commande->getCodePostal();
                $immatr = $commande->getImmatriculation();
                $date_demarche = new \Datetime();
                $commande->setDemarche($type_demarche)
                        ->setImmatriculation($immatr)
                        ->setCodePostal($code_postal)
                        ->setCeerLe($date_demarche);
                $manager->persist($commande);
                // set and get session attributes 
                $sessionManager->addArraySession(SessionManager::IDS_COMMANDE, [$commande->getId()]);
                // end treatment session

                $Vehicule = array("Immatriculation" => $immatr, "Departement" => $code_postal);
                $DateDemarche = date('Y-m-d H:i:s');
                $ECG = array("ID" => "", "TypeDemarche" => "ECGAUTO", "DateDemarche" => $DateDemarche, "Vehicule" => $Vehicule);
                $Demarche = array("ECGAUTO" => $ECG);
                $Lot = array("Demarche" => $Demarche);
                $params = array("Identification"=>$Ident, "Lot" => $Lot);
                $Immat = array("Immatriculation"=>$TMS_Immatriculation);
                $params = array("Identification"=>$Ident, "Lot" => $Lot);
                $value = $client->Envoyer($params);
                // dump($value);die;

                if(isset($value->Lot->Demarche->ECGAUTO->Reponse->Negative->Erreur)){
                    return new Response(
                        '<html><body><h1>'.$value->Lot->Demarche->ECGAUTO->Reponse->Negative->Erreur.'</h1></body></html>'
                        );
                } else {                   

                    $taxe = new Taxes();
                    $taxe->setTaxeRegionale($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRegionale)
                        ->setTaxe35cv($value->Lot->Demarche->ECGAUTO->Reponse->Positive->Taxe35cv)
                        ->setTaxeParafiscale($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeParafiscale)
                        ->setTaxeCO2($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeCO2)
                        ->setTaxeMalus($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeMalus)
                        ->setTaxeSIV($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeSIV)
                        ->setTaxeRedevanceSIV($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRedevanceSIV)
                        ->setTaxeTotale($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeTotale)
                        ->setVIN($value->Lot->Demarche->ECGAUTO->Reponse->Positive->VIN)
                        ->setCO2($value->Lot->Demarche->ECGAUTO->Reponse->Positive->CO2)
                        ->setPuissance($value->Lot->Demarche->ECGAUTO->Reponse->Positive->Puissance)
                        ->setGenre($value->Lot->Demarche->ECGAUTO->Reponse->Positive->Genre)
                        ->setPTAC($value->Lot->Demarche->ECGAUTO->Reponse->Positive->PTAC)
                        ->setEnergie($value->Lot->Demarche->ECGAUTO->Reponse->Positive->Energie)
                        ->setDateMEC(\DateTime::createFromFormat('Y-m-d', $value->Lot->Demarche->ECGAUTO->Reponse->Positive->DateMEC));
                    $commande->setTaxes($taxe);
                    $manager->persist($commande);
                    $manager->persist($taxe);
                    $manager->flush();

                    $value = $taxe;
                    $param = $this->getParamHome($commande, $sessionManager, $tabForm);

                    return $this->render('home/accueil.html.twig', $param);
                }
            }
        }
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')){
                $user = $this->getUser();
                $client = $user->getClient();
                $genre = $client->getClientGenre();

                return $this->render('home/accueil.html.twig', [
                        'genre' => $genre,
                        'client' => $client,
                        'demarches' => $type,
                        'tab' => $tabForm,
                        'database' => false,
                ]);
        }
        return $this->render('home/accueil.html.twig', [
            'demarches' => $type,
            'tab' => $tabForm,
            'database' => false,
            ]);
    }

    private function getParamHome(Commande $commande, SessionManager $sessionManager, $tabForm)
    {
        $manager = $this->getDoctrine()->getManager();
        $value = $commande->getTaxes();
        $param = [
            'commandes' => $commande, 'recap' => $commande,
            'value' => $value,        'database' => true,
        ];
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')){
            $param = array_merge([
                'genre' => $this->getUser()->getClient()->getClientGenre(),
                'client' => $this->getUser()->getClient(),
            ], $param);
            $this->getUser()->getClient()->addCommande($commande);
            $manager->persist($this->getUser()->getClient());
            $manager->flush();
        } else {
            $param = array_merge(['tab' => $tabForm], $param);
            // set and get session attributes 
            $sessionManager->addArraySession(SessionManager::IDS_COMMANDE, [$commande->getId()]);
            // end treatment session
        }

        return $param;
    }

    /**
     * @Route("/commande", name="commande")
     */
    public function demande(Request $request)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')){
            $user = $this->getUser();
            $client = $user->getClient();
            $genre = $client->getClientGenre();

            return $this->render('home/demande.html.twig', [
                'genre' => $genre,
                'client' => $client,
            ]);
        }

        return $this->render('home/demande.html.twig');
    }

    /**
     * @Route("/CommentCaMarche", name="CommentCaMarche")
     */
    public function CommentCaMarche()
    {
            if ($this->isGranted('IS_AUTHENTICATED_FULLY')){
                    $user = $this->getUser();
                    $client = $user->getClient();
                    $genre = $client->getClientGenre();

                    return $this->render('home/CommentCaMarche.html.twig', [
                            'genre' => $genre,
                            'client' => $client,
                    ]);
            }

            return $this->render('home/CommentCaMarche.html.twig');
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faq()
    {
        if($this->isGranted('IS_AUTHENTICATED_FULLY')){
            $user = $this->getUser();
            $client = $user->getClient();
            $genre = $client->getClientGenre();

            return $this->render('home/faq.html.twig', [
                'genre' => $genre,
                'client' => $client,
            ]);
        }

        return $this->render('home/faq.html.twig');
    }

	/**
	 * @Route("/CGV", name="cgv")
	 */
	public function cgv()
	{
			if($this->isGranted('IS_AUTHENTICATED_FULLY')){
					$user = $this->getUser();
					$client = $user->getClient();
					$genre = $client->getClientGenre();

					return $this->render('home/cgv.html.twig', [
							'genre' => $genre,
							'client' => $client,
					]);
            }

			return $this->render('home/cgv.html.twig');
	}

	/**
	 * @Route("/retractation", name="retractation")
	 */
	public function retractation()
	{
			if($this->isGranted('IS_AUTHENTICATED_FULLY')){
					$user = $this->getUser();
					$client = $user->getClient();
					$genre = $client->getClientGenre();

					return $this->render('home/retractation.html.twig', [
							'genre' => $genre,
							'client' => $client,
					]);
			}
			return $this->render('home/retractation.html.twig');
	}

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        if($this->isGranted('IS_AUTHENTICATED_FULLY')){
            $user = $this->getUser();
            $client = $user->getClient();
            $genre = $client->getClientGenre();

            return $this->render('home/contact.html.twig', [
                'genre' => $genre,
                'client' => $client,
            ]);
        }
        return $this->render('home/contact.html.twig');
    }

    /**
     * @Route("/espace", name="espace")
     */
    public function index()
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')){
            $user = $this->getUser();
            $client = $user->getClient();
            $genre = $client->getClientGenre();

            return $this->render('home/index.html.twig', [
                'genre' => $genre,
                'client' => $client,
            ]);
        }
        return $this->render('home/index.html.twig');
    }
	
	/**
    * @Route("/dc", name="dc")
    */
    public function dcdemande(){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $user = $this->getUser();
            $client = $user->getClient();
            $idclient = $client->getId();
            $nom = $client->getClientNom();
            $prenom = $client->getClientPrenom();
            $genre = $client->getClientGenre();
            $dateNaissance = $client->getClientDateNaissance();
            $lieuNaissance = $client->getClientLieuNaissance();
            $dpt = $client->getClientDptNaissance();
            $pays = $client->getClientPaysNaissance();

            $contact = $client->getClientContact();
            $idcontact = $contact->getId();
            $mobile = $contact->getContactTelmobile();
            $mail = $user->getEmail();

        return $this->render('demarche/dc.html.twig', [
                'idclient' => $idclient,
                'mail' => $mail,
                'mobile' => $mobile,
                'pays' => $pays,
                'genre' => $genre,
                'dateN' => $dateNaissance,
                'lieuN' => $lieuNaissance,
                'dptN' => $dpt,
                'client' => $client
        ]); 
    }

    /**
    *@Route("/dc/checkout/{tmsId}", name="checkoutdc")
    */
    public function chekoutDC($tmsId){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $client = $user->getClient();
        $idclient = $client->getId();
        $genre = $client->getClientGenre();
        $demande = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findOneBy(['client' => $idclient, 'typeDemande' => 'DC', 'TmsIdDemande' => $tmsId]);
            if($demande == NULL){
                return $this->redirectToRoute('dc');
            }
            else{
                $idDemande = $demande->getId();
                return $this->render('demarche/checkout.html.twig',[
                    'idDemande' => $idDemande,
                    'tmsId' => $tmsId,
                    'type' => 'DC',
                    'genre' => $genre,
                    'client' => $client,
                ]);
            }
               
    }
}
