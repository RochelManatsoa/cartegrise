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
use App\Repository\TarifsPrestationsRepository;
use App\Repository\DemandeRepository;
use App\Repository\TypeDemandeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Manager\SessionManager;
use App\Services\Tms\TmsClient;
use App\Manager\CommandeManager;
use App\Manager\TaxesManager;


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
        TarifsPrestationsRepository $prestation,
        CommandeRepository $commandeRepository,
        SessionManager $sessionManager,
        TmsClient $tmsClient,
        CommandeManager $commandeManager,
        TaxesManager $taxesManager
        )
    {

        // dump($this->getUser()->getClient()->getCountDem());die;
        
        $commande = $commandeManager->createCommande();

        $type = $demarche->findAll();
        foreach($type as $typeId) {
            $defaultType = $demarche->find($typeId->getId());            
            $form = $this->createForm(CommandeType::class, $commande , ['defaultType'=>$defaultType]);
            $num = $typeId->getId();
            $tabForm[$num] = $form->createView();
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ifCommande = $commandeRepository->findOneBy([
                'immatriculation' => $commande->getImmatriculation(),
                'codePostal' => $commande->getCodePostal(),
                'demarche' => $commande->getDemarche(),
            ]);
            $sessionManager->initSession();
            if (!is_null($ifCommande)) {
                $recapCommand = $ifCommande;
                $param = $this->getParamHome($recapCommand, $sessionManager, $tabForm);

                return $this->render('home/accueil.html.twig', $param);
            } else {
                $tmsResponse = $commandeManager->tmsEnvoyer($commande);

                if (!$tmsResponse->isSuccessfull()) {
                    return new Response(
                        '<html><body><h1>'.$value->Lot->Demarche->ECGAUTO->Reponse->Negative->Erreur.'</h1></body></html>'
                    );
                } else {                   
                    $value = $tmsResponse->getRawData();

                    $taxe = $taxesManager->createFromTmsResponse($tmsResponse);
                    $commande->setTaxes($taxe);
                    $manager->persist($commande);
                    $manager->persist($taxe);
                    $manager->flush();

                    $param = $this->getParamHome($commande, $sessionManager, $tabForm);

                    return $this->render('home/accueil.html.twig', $param);
                }
            }
        }

        $homeParams = [
            'demarches' => $type,
            'tab' => $tabForm,
            'database' => false,
        ];

        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $client = $this->getUser()->getClient();

            $homeParams['genre'] = $client->getClientGenre();
            $homeParams['client'] = $client;
        }

        return $this->render('home/accueil.html.twig', $homeParams);
    }

    private function getParamHome(Commande $commande, SessionManager $sessionManager, $tabForm)
    {
        $manager = $this->getDoctrine()->getManager();
        $value = $commande->getTaxes();
        $majoration = 0;
        $service = $value->getTaxeRegionale();

        if ($service > 101 && $service < 300) {
            $majoration = 7;
        }elseif ($service > 301 && $service < 400) {
            $majoration = 11;
        }elseif ($service > 401 && $service < 600) {
            $majoration = 17;
        }elseif ($service > 601 && $service < 800) {
            $majoration = 21;
        }elseif ($service > 801 && $service < 1000) {
            $majoration = 27;
        }elseif ($service > 1001 && $service < 1499) {
            $majoration = 31;
        }elseif ($service > 1500) {
            $majoration = 41;
        }
        $param = [
            'commandes' => $commande, 'recap' => $commande,
            'value' => $value,        'database' => true,   'majoration' => $majoration,
        ];
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
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
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
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
            if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
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
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
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
			if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
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
			if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
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
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
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
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
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
    public function dcdemande() {
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
    public function chekoutDC($tmsId) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $client = $user->getClient();
        $idclient = $client->getId();
        $genre = $client->getClientGenre();
        $demande = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findOneBy(['client' => $idclient, 'typeDemande' => 'DC', 'TmsIdDemande' => $tmsId]);
            if ($demande == NULL) {
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
