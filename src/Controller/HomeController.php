<?php

namespace App\Controller;

use App\Entity\{Demande, ContactUs, Commande, Taxes, TypeDemande, DivnInit, User, NotificationEmail};
use App\Form\{DemandeType, CommandeType, ContactUsType, FormulaireType};
use App\Repository\Blog\{ArticleRepository, CategorieRepository, CommentaireRepository};
use App\Entity\Blog\{Article, Categorie};
use App\Repository\{CommandeRepository, TaxesRepository, TarifsPrestationsRepository, DemandeRepository, TypeDemandeRepository};
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Tms\TmsClient;
use App\Manager\{SessionManager, CommandeManager, TaxesManager, CarInfoManager, DivnInitManager, ContactUsManager, NotificationManager, NotificationEmailManager, MailManager};
use App\Form\DivnInitType;
use App\Manager\Mercure\MercureManager;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\PreviewEmail;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class HomeController extends AbstractController
{
    public function __construct(
        CsrfTokenManagerInterface $tokenManager = null
    )
    {
        $this->tokenManager = $tokenManager;
    }

    /**
     * function to get if commande
     *
     * @return void
     */
    /**
     * function to get if command already sent today
     *
     * @param Request $request
     * @param CommandeRepository $commandeRepository
     * @param string $todayId
     * @return void
     */
    private function getIfCommande($request, $commandeRepository, $todayIp)
    {
        $ifCommande = null;
            if ($this->getUser() instanceof User && $this->getUser()->hasRole("ROLE_ADMIN")) {
                $ifCommande = null;
            } else {
                $ifCommande = $commandeRepository->findOneBy([
                    'dayIp' => $todayIp
                ]);
            }
        return $ifCommande;

    }
    /**
     * @Route("/", name="Accueil",  options={"sitemap" = true})
     * @Route("/", name="home",  options={"sitemap" = true})
     * @Route("/demande-duplicata-certificat-immatriculation", name="dup",  options={"sitemap" = true})
     * @Route("/changement-titulaire-vehicule-occasion", name="ctvo",  options={"sitemap" = true})
     * @Route("/changement-adresse-certificat-immatriculation", name="dca",  options={"sitemap" = true})
     */
    public function accueil(
        Request $request,
        ?Categorie $categorie = null,
        TypeDemandeRepository $demarche,
        ObjectManager $manager,
        TaxesRepository $taxesRepository,
        TarifsPrestationsRepository $prestation,
        CommandeRepository $commandeRepository,
        SessionManager $sessionManager,
        ArticleRepository $articleRepository,
        CategorieRepository $categorieRepository,
        TmsClient $tmsClient,
        CommandeManager $commandeManager,
        CarInfoManager $carInfoManager,
        TaxesManager $taxesManager,
        DivnInitManager $divnInitManager,
        MercureManager $mercureManager,
        NotificationManager $notificationManager
        )
    {
        $routeName = $request->attributes->get('_route');
        $type = $demarche->findAll();
        $department = null;
        if ($request->query->has('department')) {
            $department = $request->query->get('department');
        }
        $info = null;
        if ($request->query->has('info')) {
            $info = $request->query->get('info');
        }
        $defaultDemarche = null;
        if($routeName !== "Accueil" || $routeName !== "home"){
            $defaultDemarche = $demarche->findOneBy(['type' => strtoupper($routeName)]);
        }
        $commande = $commandeManager->createCommande();
        foreach($type as $typeId) {
            $defaultType = $demarche->find($typeId->getId());
            if ($typeId->getType() === "DIVN")
            {
                $divnInit = new DivnInit();
                $formDivn = $this->createForm(DivnInitType::class, $divnInit, ['departement'=>$commande->DEPARTMENTS]);
                $num = $typeId->getId();
                $tabForm[$num] = $formDivn->createView();
            } else {
                $form = $this->createForm(CommandeType::class, $commande , ['defaultType'=>$defaultType, 'departement'=>$commande->DEPARTMENTS]);
                $num = $typeId->getId();
                $tabForm[$num] = $form->createView();
            }
        }
        // check if user already send commande today
        $ip = $request->server->get("REMOTE_ADDR");
        $todayIp = (new \DateTime())->format('d-m-Y') . $ip;
        $ifCommande = $ip == '37.71.247.34' ? null : $this->getIfCommande($request, $commandeRepository, $todayIp);

        $formulaire = $this->createForm(FormulaireType::class, $commande , [
            'departement'=>$commande->DEPARTMENTS,
            "hasCaptcha" => ($ifCommande instanceof Commande)
            ]);

        $form->handleRequest($request);
        $formDivn->handleRequest($request);
        $formulaire->handleRequest($request);

        if ($formDivn->isSubmitted() && $formDivn->isValid()) {
            $divnInit = $formDivn->getData();
            $divnInitManager->manageSubmit($divnInit);
            $param = $this->getParamHome($divnInit->getCommande(), $sessionManager, $tabForm);

            return $this->render('home/accueil.html.twig', $param);
        }


         if ($form->isSubmitted() && $form->isValid() || $formulaire->isSubmitted() && $formulaire->isValid()) {
             

            $sessionManager->initSession();
            if (!is_null($ifCommande)) {
                $ifCommandeExist = $commandeRepository->findOneBy([
                    'immatriculation' => $commande->getImmatriculation(),
                    'codePostal' => $commande->getCodePostal(),
                    'demarche' => $commande->getDemarche(),
                    'dayIp' => $todayIp
                ]);

                if ($ifCommandeExist instanceof Commande){
                    $param = $this->getParamHome($ifCommandeExist, $sessionManager, $tabForm);

                    return $this->render('home/accueil.html.twig', $param);
                }
            // else {
            //         return $this->redirectToRoute('Accueil');
            //     }
                
                
            } else {

                $tmsInfoImmat = $commandeManager->tmsInfoImmat($commande);
                if (!$tmsInfoImmat->isSuccessfull()) {
                    throw new \Exception('Veuillez Réessayer plus tard');
                }
                
                $tmsResponse = $commandeManager->tmsEnvoyer($commande, $tmsInfoImmat);
                if (!$tmsResponse->isSuccessfull()) {
                    return new Response($tmsResponse->getErrorMessage());
                } else {
                    $taxe = $taxesManager->createFromTmsResponse($tmsResponse, $commande, $tmsInfoImmat);
                    $carInfo = $carInfoManager->createInfoFromTmsImmatResponse($tmsInfoImmat);
                    $commande->setTaxes($taxe);
                    $commande->setCarInfo($carInfo);
                    $commande->setDayIp($todayIp);
                    $manager->persist($commande);
                    $manager->persist($taxe);

                    $manager->flush();

                    // The Publisher service is an invokable object
                    $data = [
                            'immat' => $commande->getImmatriculation(),
                            'department' => $commande->getCodePostal(),
                            'demarche' => $commande->getDemarche()->getType(),
                            'id' => $commande->getId(),
                    ];
                    $this->saveToSession($commande, $sessionManager, $tabForm);
                    // preview of email relance send
                    $commandeManager->generatePreviewEmailRelance($commande, PreviewEmail::MAIL_RELANCE_DEMARCHE);
                    return $this->redirectToRoute('commande_recap', ['commande'=> $commande->getId()]);

                    // $param = $this->getParamHome($commande, $sessionManager, $tabForm);

                    // return $this->render('home/accueil.html.twig', $param);
                }
            }
        }

        if (!$categorie instanceof Categorie) {
            if($categorieRepository->findOneBy(['slug'=> 'a-laffiche']) !== null){
                $categorie = $categorieRepository->findOneBy(['slug'=> 'a-laffiche']);
            }else{
                $categorie = $categorieRepository->gatLastInsertedCategory();
            }
        }
        
        $articles = $articleRepository->findByCatagories($categorie->getId());

        $homeParams = [
            'demarches' => $type,
            'tab' => $tabForm,
            'formulaire' => $formulaire->createView(),
            'database' => false,
            'defaultDepartment' => $department,
            'defaultDemarche' => $defaultDemarche,
            'articles' => $articles,
            'info' => $info,
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
        $taxe = $commande->getTaxes();
        $majoration = 0;
        $param = [
            'commande' => $commande, 'recap' => $commande,
            'taxe' => $taxe,        'database' => true,   'majoration' => $majoration,
            'user_csrf' => $this->getTokenAction()
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
    private function saveToSession(Commande $commande, SessionManager $sessionManager, $tabForm)
    {
        $manager = $this->getDoctrine()->getManager();
        $taxe = $commande->getTaxes();
        $majoration = 0;
        
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->getUser()->getClient()->addCommande($commande);
            $manager->persist($this->getUser()->getClient());
            $manager->flush();
        } else {
            
            $sessionManager->addArraySession(SessionManager::IDS_COMMANDE, [$commande->getId()]);
            // end treatment session
        }

        return "ok";
    }

    /**
     * @Route("/comment-ca-marche", name="CommentCaMarche",  options={"sitemap" = true})
     */
    public function CommentCaMarche(
        Request $request,
        TypeDemandeRepository $demarche,
        ObjectManager $manager,
        TaxesRepository $taxesRepository,
        TarifsPrestationsRepository $prestation,
        CommandeRepository $commandeRepository,
        SessionManager $sessionManager,
        TmsClient $tmsClient,
        CommandeManager $commandeManager,
        CarInfoManager $carInfoManager,
        TaxesManager $taxesManager,
        DivnInitManager $divnInitManager,
        MercureManager $mercureManager,
        NotificationManager $notificationManager
        )
    {
        $type = $demarche->findAll();
        $commande = $commandeManager->createCommande();
        foreach($type as $typeId) {
            $defaultType = $demarche->find($typeId->getId());
            if ($typeId->getType() === "DIVN")
            {
                $divnInit = new DivnInit();
                $formDivn = $this->createForm(DivnInitType::class, $divnInit, ['departement'=>$commande->DEPARTMENTS]);
                $num = $typeId->getId();
                $tabForm[$num] = $formDivn->createView();
            } else {
                $form = $this->createForm(CommandeType::class, $commande , ['defaultType'=>$defaultType, 'departement'=>$commande->DEPARTMENTS]);
                $num = $typeId->getId();
                $tabForm[$num] = $form->createView();
            }
        }
        $formulaire = $this->createForm(FormulaireType::class, $commande , ['departement'=>$commande->DEPARTMENTS]);

        $form->handleRequest($request);
        $formDivn->handleRequest($request);
        $formulaire->handleRequest($request);

        if ($formDivn->isSubmitted() && $formDivn->isValid()) {
             
            return $this->redirectToRoute('error_simulation');

            // $divnInit = $formDivn->getData();
            // $divnInitManager->manageSubmit($divnInit);
            // $param = $this->getParamHome($divnInit->getCommande(), $sessionManager, $tabForm);

            // return $this->render('home/accueil.html.twig', $param);
        }


        if ($form->isSubmitted() && $form->isValid() || $formulaire->isSubmitted() && $formulaire->isValid()) {
             
            return $this->redirectToRoute('error_simulation');

            // $ifCommande = $commandeRepository->findOneBy([
            //     'immatriculation' => $commande->getImmatriculation(),
            //     'codePostal' => $commande->getCodePostal(),
            //     'demarche' => $commande->getDemarche(),
            // ]);

            // if($commande->getDemarche()->getType() === 'DIVN'){

            //     return $this->redirectToRoute('Accueil');
            // }
            // $sessionManager->initSession();
            // // if (!is_null($ifCommande)) {
            // //     $param = $this->getParamHome($ifCommande, $sessionManager, $tabForm);

            // //     return $this->render('home/accueil.html.twig', $param);
            // // } else {

            //     $tmsInfoImmat = $commandeManager->tmsInfoImmat($commande);
            //     if (!$tmsInfoImmat->isSuccessfull()) {
            //         throw new \Exception('Veuillez Réessayer plus tard');
            //     }
            //     $tmsResponse = $commandeManager->tmsEnvoyer($commande, $tmsInfoImmat);

            //     if (!$tmsResponse->isSuccessfull()) {
            //         return new Response($tmsResponse->getErrorMessage());
            //     } else {
            //         $taxe = $taxesManager->createFromTmsResponse($tmsResponse, $commande, $tmsInfoImmat);
            //         $carInfo = $carInfoManager->createInfoFromTmsImmatResponse($tmsInfoImmat);
            //         $commande->setTaxes($taxe);
            //         $commande->setCarInfo($carInfo);
            //         $manager->persist($commande);
            //         $manager->persist($taxe);

            //         $manager->flush();

            //         // The Publisher service is an invokable object
            //         // $data = [
            //         //         'immat' => $commande->getImmatriculation(),
            //         //         'department' => $commande->getCodePostal(),
            //         //         'demarche' => $commande->getDemarche()->getType(),
            //         //         'id' => $commande->getId(),
            //         // ];
            //         // $mercureManager->publish(
            //         //     'http://cgofficiel.com/addNewSimulator',
            //         //     'commande',
            //         //     $data,
            //         //     'new Simulation is insert'
            //         // );

            //         // $notificationManager->saveNotification([
            //         //     "type" => 'commande', 
            //         //     "data" => $data,
            //         // ]);
            //         $this->saveToSession($commande, $sessionManager, $tabForm);
            //         return $this->redirectToRoute('commande_recap', ['commande'=> $commande->getId()]);

            //         // $param = $this->getParamHome($commande, $sessionManager, $tabForm);

            //         // return $this->render('home/accueil.html.twig', $param);
                // }
            // }
        }

        $homeParams = [
            'demarches' => $type,
            'tab' => $tabForm,
            'formulaire' => $formulaire->createView(),
            'database' => false,
        ];

        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $client = $this->getUser()->getClient();

            $homeParams['genre'] = $client->getClientGenre();
            $homeParams['client'] = $client;
        }

        return $this->render('home/CommentCaMarche.html.twig', $homeParams);
    }

    /**
     * @Route("/conseils-pour-acheter-son-vehicule/{categorie}")
     * @Route("/conseils-pour-acheter-son-vehicule", name="advice_buying_car",  options={"sitemap" = true})
     */
    public function adviceBuyingCar(
        Request $request,
        ?Categorie $categorie = null,
        TypeDemandeRepository $demarche,
        ObjectManager $manager,
        TaxesRepository $taxesRepository,
        TarifsPrestationsRepository $prestation,
        CommandeRepository $commandeRepository,
        ArticleRepository $articleRepository,
        CategorieRepository $categorieRepository,
        SessionManager $sessionManager,
        TmsClient $tmsClient,
        CommandeManager $commandeManager,
        CarInfoManager $carInfoManager,
        TaxesManager $taxesManager,
        DivnInitManager $divnInitManager,
        MercureManager $mercureManager,
        NotificationManager $notificationManager,
        PaginatorInterface $paginator
        )
    {
        $type = $demarche->findAll();
        $commande = $commandeManager->createCommande();
        foreach($type as $typeId) {
            $defaultType = $demarche->find($typeId->getId());
            if ($typeId->getType() === "DIVN")
            {
                $divnInit = new DivnInit();
                $formDivn = $this->createForm(DivnInitType::class, $divnInit, ['departement'=>$commande->DEPARTMENTS]);
                $num = $typeId->getId();
                $tabForm[$num] = $formDivn->createView();
            } else {
                $form = $this->createForm(CommandeType::class, $commande , ['defaultType'=>$defaultType, 'departement'=>$commande->DEPARTMENTS]);
                $num = $typeId->getId();
                $tabForm[$num] = $form->createView();
            }
        }
        $formulaire = $this->createForm(FormulaireType::class, $commande , ['departement'=>$commande->DEPARTMENTS]);

        $form->handleRequest($request);
        $formDivn->handleRequest($request);
        $formulaire->handleRequest($request);

        if ($formDivn->isSubmitted() && $formDivn->isValid()) {
             
            return $this->redirectToRoute('error_simulation');

            // $divnInit = $formDivn->getData();
            // $divnInitManager->manageSubmit($divnInit);
            // $param = $this->getParamHome($divnInit->getCommande(), $sessionManager, $tabForm);

            // return $this->render('home/accueil.html.twig', $param);
        }

        if ($form->isSubmitted() && $form->isValid() || $formulaire->isSubmitted() && $formulaire->isValid()) {
             
            return $this->redirectToRoute('error_simulation');

            // $ifCommande = $commandeRepository->findOneBy([
            //     'immatriculation' => $commande->getImmatriculation(),
            //     'codePostal' => $commande->getCodePostal(),
            //     'demarche' => $commande->getDemarche(),
            // ]);

            // if($commande->getDemarche()->getType() === 'DIVN'){

            //     return $this->redirectToRoute('Accueil');
            // }
            // $sessionManager->initSession();
            // // if (!is_null($ifCommande)) {
            // //     $param = $this->getParamHome($ifCommande, $sessionManager, $tabForm);

            // //     return $this->render('home/accueil.html.twig', $param);
            // // } else {

            //     $tmsInfoImmat = $commandeManager->tmsInfoImmat($commande);
            //     if (!$tmsInfoImmat->isSuccessfull()) {
            //         throw new \Exception('Veuillez Réessayer plus tard');
            //     }
            //     $tmsResponse = $commandeManager->tmsEnvoyer($commande, $tmsInfoImmat);

            //     if (!$tmsResponse->isSuccessfull()) {
            //         return new Response($tmsResponse->getErrorMessage());
            //     } else {
            //         $taxe = $taxesManager->createFromTmsResponse($tmsResponse, $commande, $tmsInfoImmat);
            //         $carInfo = $carInfoManager->createInfoFromTmsImmatResponse($tmsInfoImmat);
            //         $commande->setTaxes($taxe);
            //         $commande->setCarInfo($carInfo);
            //         $manager->persist($commande);
            //         $manager->persist($taxe);

            //         $manager->flush();

            //         // The Publisher service is an invokable object
            //         // $data = [
            //         //         'immat' => $commande->getImmatriculation(),
            //         //         'department' => $commande->getCodePostal(),
            //         //         'demarche' => $commande->getDemarche()->getType(),
            //         //         'id' => $commande->getId(),
            //         // ];
            //         // $mercureManager->publish(
            //         //     'http://cgofficiel.com/addNewSimulator',
            //         //     'commande',
            //         //     $data,
            //         //     'new Simulation is insert'
            //         // );

            //         // $notificationManager->saveNotification([
            //         //     "type" => 'commande', 
            //         //     "data" => $data,
            //         // ]);
            //         $this->saveToSession($commande, $sessionManager, $tabForm);
            //         return $this->redirectToRoute('commande_recap', ['commande'=> $commande->getId()]);

            //         // $param = $this->getParamHome($commande, $sessionManager, $tabForm);

            //         // return $this->render('home/accueil.html.twig', $param);
            //     }
            // }
        }

        if (!$categorie instanceof Categorie) {
            if($categorieRepository->findOneBy(['slug'=> 'a-laffiche']) !== null){
                $categorie = $categorieRepository->findOneBy(['slug'=> 'a-laffiche']);
            }else{
                $categorie = $categorieRepository->gatLastInsertedCategory();
            }
        }
        // dd($categorie);
        $repo = $articleRepository->findByCatagories($categorie->getId());
        // dd($repo);
        /* @var $paginator \Knp\Component\Pager\Paginator */
        $articles = $paginator->paginate(
            $repo, $request->query->getInt('page', 1), 9
            );

        $homeParams = [
            'demarches' => $type,
            'tab' => $tabForm,
            'formulaire' => $formulaire->createView(),
            'database' => false,
            'articles' => $articles,
        ];

        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $client = $this->getUser()->getClient();

            $homeParams['genre'] = $client->getClientGenre();
            $homeParams['client'] = $client;
        }

        return $this->render('home/conseilAchat.html.twig', $homeParams);
    }

    /**
     * @Route("/foire-aux-questions", name="faq", options={"sitemap" = true})
     */
    public function faq()
    {
        return $this->render('home/faq.html.twig');
    }

	/**
	 * @Route("/conditions-generale-de-vente", name="cgv", options={"sitemap" = true})
	 */
	public function cgv()
	{
		return $this->render('home/cgv.html.twig');
    }
    /**
	 * @Route("/mentions", name="mentions", options={"sitemap" = true})
	 */
	public function mentions()
	{
		return $this->render('home/mentions.html.twig');
	}

	/**
	 * @Route("/retractation", name="retractation", options={"sitemap" = true})
	 */
	public function retractation()
	{
        return $this->render('home/retractation.html.twig');
	}

    /**
     * @Route("/contact", name="contact", options={"sitemap" = true})
     */
    public function contact(
        Request $request, 
        ContactUsManager $contactUsManger,
        MailManager $mailManager,
        NotificationEmailManager $notificationManager
        )
    {
        $contactU = new ContactUs();
        $form = $this->createForm(ContactUsType::class, $contactU);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // $adminEmails = $notificationManager->getAllEmailOf(NotificationEmail::PAIMENT_NOTIF);
            $adminEmails = ["service.client@cgofficiel.fr"];
            $template = 'email/contact/contactUs.mail.twig';
            $object = 'Nouvelle entrée: Formulaire de contact';
            $contactUsManger->save($data);
            $mailManager->sendEmail($adminEmails, $template, $object, [ 'responses'=>$data]);

            return $this->redirectToRoute('home');
        }

        return $this->render('home/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/prix-carte-grise", name="prix_carte_grise", options={"sitemap" = true})
     */
    public function accueilSimulator()
    {
        return $this->render('home/prix.html.twig');
    }

    /**
     * @Route("/formulaire", name="formulaire")
     */
    public function formulaire(
        Request $request,
        ObjectManager $manager,
        TaxesRepository $taxesRepository,
        TarifsPrestationsRepository $prestation,
        CommandeRepository $commandeRepository,
        SessionManager $sessionManager,
        TmsClient $tmsClient,
        CommandeManager $commandeManager,
        CarInfoManager $carInfoManager,
        TaxesManager $taxesManager,
        DivnInitManager $divnInitManager
        )
    {
        $commande = $commandeManager->createCommande();
        $form = $this->createForm(FormulaireType::class, $commande , ['departement'=>$commande->DEPARTMENTS]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ifCommande = $commandeRepository->findOneBy([
                'immatriculation' => $commande->getImmatriculation(),
                'codePostal' => $commande->getCodePostal(),
                'demarche' => $commande->getDemarche(),
            ]);
            if($commande->getDemarche()->getType() === 'DIVN'){

                return $this->redirectToRoute('Accueil');
            }
            $sessionManager->initSession();
            // if (!is_null($ifCommande)) {
            //     $param = $this->getParamHome($ifCommande, $sessionManager, $tabForm);

            //     return $this->render('home/accueil.html.twig', $param);
            // } else {

                $tmsInfoImmat = $commandeManager->tmsInfoImmat($commande);
                if (!$tmsInfoImmat->isSuccessfull()) {
                    throw new \Exception('Veuillez Réessayer plus tard');
                }
                $tmsResponse = $commandeManager->tmsEnvoyer($commande, $tmsInfoImmat);

                if (!$tmsResponse->isSuccessfull()) {
                    return new Response($tmsResponse->getErrorMessage());
                } else {
                    $taxe = $taxesManager->createFromTmsResponse($tmsResponse, $commande, $tmsInfoImmat);
                    $carInfo = $carInfoManager->createInfoFromTmsImmatResponse($tmsInfoImmat);
                    $commande->setTaxes($taxe);
                    $commande->setCarInfo($carInfo);
                    $manager->persist($commande);
                    $manager->persist($taxe);

                    $manager->flush();
                    $param = $this->getParamHome($commande, $sessionManager, $form);

                    return $this->render('home/accueil.html.twig', $param);
                }
            // }
        }

        $homeParams = [
            'form' => $form->createView(),
            'database' => false,
        ];

        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $client = $this->getUser()->getClient();

            $homeParams['genre'] = $client->getClientGenre();
            $homeParams['client'] = $client;
        }

        return $this->render('home/formulaire.html.twig', $homeParams);
    }

    /**
     * @Route("/documents-telechargeables", name="doc_telechargeable", options={"sitemap" = true})
     */
    public function doc_telechargeableAction(
        Request $request,
        TypeDemandeRepository $demarche,
        ObjectManager $manager,
        TaxesRepository $taxesRepository,
        TarifsPrestationsRepository $prestation,
        CommandeRepository $commandeRepository,
        SessionManager $sessionManager,
        TmsClient $tmsClient,
        CommandeManager $commandeManager,
        CarInfoManager $carInfoManager,
        TaxesManager $taxesManager,
        DivnInitManager $divnInitManager,
        MercureManager $mercureManager,
        NotificationManager $notificationManager
        )
    {
        $type = $demarche->findAll();
        $commande = $commandeManager->createCommande();
        foreach($type as $typeId) {
            $defaultType = $demarche->find($typeId->getId());
            if ($typeId->getType() === "DIVN")
            {
                $divnInit = new DivnInit();
                $formDivn = $this->createForm(DivnInitType::class, $divnInit, ['departement'=>$commande->DEPARTMENTS]);
                $num = $typeId->getId();
                $tabForm[$num] = $formDivn->createView();
            } else {
                $form = $this->createForm(CommandeType::class, $commande , ['defaultType'=>$defaultType, 'departement'=>$commande->DEPARTMENTS]);
                $num = $typeId->getId();
                $tabForm[$num] = $form->createView();
            }
        }
        $formulaire = $this->createForm(FormulaireType::class, $commande , ['departement'=>$commande->DEPARTMENTS]);

        $form->handleRequest($request);
        $formDivn->handleRequest($request);
        $formulaire->handleRequest($request);

        if ($formDivn->isSubmitted() && $formDivn->isValid()) {
             
            return $this->redirectToRoute('error_simulation');

            // $divnInit = $formDivn->getData();
            // $divnInitManager->manageSubmit($divnInit);
            // $param = $this->getParamHome($divnInit->getCommande(), $sessionManager, $tabForm);

            // return $this->render('home/accueil.html.twig', $param);
        }


        if ($form->isSubmitted() && $form->isValid() || $formulaire->isSubmitted() && $formulaire->isValid()) {
             
            return $this->redirectToRoute('error_simulation');

            // $ifCommande = $commandeRepository->findOneBy([
            //     'immatriculation' => $commande->getImmatriculation(),
            //     'codePostal' => $commande->getCodePostal(),
            //     'demarche' => $commande->getDemarche(),
            // ]);

            // if($commande->getDemarche()->getType() === 'DIVN'){

            //     return $this->redirectToRoute('Accueil');
            // }
            // $sessionManager->initSession();
            // // if (!is_null($ifCommande)) {
            // //     $param = $this->getParamHome($ifCommande, $sessionManager, $tabForm);

            // //     return $this->render('home/accueil.html.twig', $param);
            // // } else {

            //     $tmsInfoImmat = $commandeManager->tmsInfoImmat($commande);
            //     if (!$tmsInfoImmat->isSuccessfull()) {
            //         throw new \Exception('Veuillez Réessayer plus tard');
            //     }
            //     $tmsResponse = $commandeManager->tmsEnvoyer($commande, $tmsInfoImmat);

            //     if (!$tmsResponse->isSuccessfull()) {
            //         return new Response($tmsResponse->getErrorMessage());
            //     } else {
            //         $taxe = $taxesManager->createFromTmsResponse($tmsResponse, $commande, $tmsInfoImmat);
            //         $carInfo = $carInfoManager->createInfoFromTmsImmatResponse($tmsInfoImmat);
            //         $commande->setTaxes($taxe);
            //         $commande->setCarInfo($carInfo);
            //         $manager->persist($commande);
            //         $manager->persist($taxe);

            //         $manager->flush();

            //         // The Publisher service is an invokable object
            //         // $data = [
            //         //         'immat' => $commande->getImmatriculation(),
            //         //         'department' => $commande->getCodePostal(),
            //         //         'demarche' => $commande->getDemarche()->getType(),
            //         //         'id' => $commande->getId(),
            //         // ];
            //         // $mercureManager->publish(
            //         //     'http://cgofficiel.com/addNewSimulator',
            //         //     'commande',
            //         //     $data,
            //         //     'new Simulation is insert'
            //         // );

            //         // $notificationManager->saveNotification([
            //         //     "type" => 'commande', 
            //         //     "data" => $data,
            //         // ]);
            //         $this->saveToSession($commande, $sessionManager, $tabForm);
            //         return $this->redirectToRoute('commande_recap', ['commande'=> $commande->getId()]);

            //         // $param = $this->getParamHome($commande, $sessionManager, $tabForm);

            //         // return $this->render('home/accueil.html.twig', $param);
            //     }
            // // }
        }

        $homeParams = [
            'demarches' => $type,
            'tab' => $tabForm,
            'formulaire' => $formulaire->createView(),
            'database' => false,
        ];

        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $client = $this->getUser()->getClient();

            $homeParams['genre'] = $client->getClientGenre();
            $homeParams['client'] = $client;
        }

        return $this->render('home/doc_telechargeable.html.twig', $homeParams);
    }
    /**
     * @Route("/piece-a-fournir", name="piece_a_fournir", options={"sitemap" = true})
     */
    public function pieceAFournirAction(
        Request $request,
        TypeDemandeRepository $demarche,
        ObjectManager $manager,
        TaxesRepository $taxesRepository,
        TarifsPrestationsRepository $prestation,
        CommandeRepository $commandeRepository,
        SessionManager $sessionManager,
        TmsClient $tmsClient,
        CommandeManager $commandeManager,
        CarInfoManager $carInfoManager,
        TaxesManager $taxesManager,
        DivnInitManager $divnInitManager,
        MercureManager $mercureManager,
        NotificationManager $notificationManager
        )
    {
        $type = $demarche->findAll();
        $commande = $commandeManager->createCommande();
        foreach($type as $typeId) {
            $defaultType = $demarche->find($typeId->getId());
            if ($typeId->getType() === "DIVN")
            {
                $divnInit = new DivnInit();
                $formDivn = $this->createForm(DivnInitType::class, $divnInit, ['departement'=>$commande->DEPARTMENTS]);
                $num = $typeId->getId();
                $tabForm[$num] = $formDivn->createView();
            } else {
                $form = $this->createForm(CommandeType::class, $commande , ['defaultType'=>$defaultType, 'departement'=>$commande->DEPARTMENTS]);
                $num = $typeId->getId();
                $tabForm[$num] = $form->createView();
            }
        }
        $formulaire = $this->createForm(FormulaireType::class, $commande , ['departement'=>$commande->DEPARTMENTS]);

        $form->handleRequest($request);
        $formDivn->handleRequest($request);
        $formulaire->handleRequest($request);

        if ($formDivn->isSubmitted() && $formDivn->isValid()) {
             
            return $this->redirectToRoute('error_simulation');

            // $divnInit = $formDivn->getData();
            // $divnInitManager->manageSubmit($divnInit);
            // $param = $this->getParamHome($divnInit->getCommande(), $sessionManager, $tabForm);

            // return $this->render('home/accueil.html.twig', $param);
        }


        if ($form->isSubmitted() && $form->isValid() || $formulaire->isSubmitted() && $formulaire->isValid()) {
             
            return $this->redirectToRoute('error_simulation');

            // $ifCommande = $commandeRepository->findOneBy([
            //     'immatriculation' => $commande->getImmatriculation(),
            //     'codePostal' => $commande->getCodePostal(),
            //     'demarche' => $commande->getDemarche(),
            // ]);

            // if($commande->getDemarche()->getType() === 'DIVN'){

            //     return $this->redirectToRoute('Accueil');
            // }
            // $sessionManager->initSession();
            // // if (!is_null($ifCommande)) {
            // //     $param = $this->getParamHome($ifCommande, $sessionManager, $tabForm);

            // //     return $this->render('home/accueil.html.twig', $param);
            // // } else {

            //     $tmsInfoImmat = $commandeManager->tmsInfoImmat($commande);
            //     if (!$tmsInfoImmat->isSuccessfull()) {
            //         throw new \Exception('Veuillez Réessayer plus tard');
            //     }
            //     $tmsResponse = $commandeManager->tmsEnvoyer($commande, $tmsInfoImmat);

            //     if (!$tmsResponse->isSuccessfull()) {
            //         return new Response($tmsResponse->getErrorMessage());
            //     } else {
            //         $taxe = $taxesManager->createFromTmsResponse($tmsResponse, $commande, $tmsInfoImmat);
            //         $carInfo = $carInfoManager->createInfoFromTmsImmatResponse($tmsInfoImmat);
            //         $commande->setTaxes($taxe);
            //         $commande->setCarInfo($carInfo);
            //         $manager->persist($commande);
            //         $manager->persist($taxe);

            //         $manager->flush();

            //         // The Publisher service is an invokable object
            //         // $data = [
            //         //         'immat' => $commande->getImmatriculation(),
            //         //         'department' => $commande->getCodePostal(),
            //         //         'demarche' => $commande->getDemarche()->getType(),
            //         //         'id' => $commande->getId(),
            //         // ];
            //         // $mercureManager->publish(
            //         //     'http://cgofficiel.com/addNewSimulator',
            //         //     'commande',
            //         //     $data,
            //         //     'new Simulation is insert'
            //         // );

            //         // $notificationManager->saveNotification([
            //         //     "type" => 'commande', 
            //         //     "data" => $data,
            //         // ]);
            //         $this->saveToSession($commande, $sessionManager, $tabForm);
            //         return $this->redirectToRoute('commande_recap', ['commande'=> $commande->getId()]);

            //         // $param = $this->getParamHome($commande, $sessionManager, $tabForm);

            //         // return $this->render('home/accueil.html.twig', $param);
            //     }
            // // }
        }

        $homeParams = [
            'demarches' => $type,
            'tab' => $tabForm,
            'formulaire' => $formulaire->createView(),
            'database' => false,
        ];

        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $client = $this->getUser()->getClient();

            $homeParams['genre'] = $client->getClientGenre();
            $homeParams['client'] = $client;
        }

        return $this->render('home/pieceAFournir.html.twig', $homeParams);
    }

    public function getTokenAction()  
    {
        $csrf = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;
        return $csrf;
    }

    /**
     * @Route("/mentions-legales", name="mentions_legales", options={"sitemap" = true})
     */
    public function mentionsLegales()
    {
        return $this->render('home/mentionsLegales.html.twig');
    }

    /**
     * @Route("/api/accueil", name="api_accueil")
     */
    public function apiAccueil(
        Request $request,
        TypeDemandeRepository $demarche,
        ObjectManager $manager,
        SessionManager $sessionManager,
        CommandeManager $commandeManager,
        CarInfoManager $carInfoManager,
        TaxesManager $taxesManager,
        MercureManager $mercureManager,
        NotificationManager $notificationManager
        )
    {
        $type = $demarche->findAll();
        $commande = $commandeManager->createCommande();
        foreach($type as $typeId) {
            $defaultType = $demarche->find($typeId->getId());
            if ($typeId->getType() === "DIVN")
            {
                $divnInit = new DivnInit();
                $formDivn = $this->createForm(DivnInitType::class, $divnInit, ['departement'=>$commande->DEPARTMENTS]);
                $num = $typeId->getId();
                $tabForm[$num] = $formDivn->createView();
            } else {
                $form = $this->createForm(CommandeType::class, $commande , [
                    'defaultType'=>$defaultType, 
                    'departement'=>$commande->DEPARTMENTS,
                    'csrf_protection' => false
                    ]);
                $num = $typeId->getId();
                $tabForm[$num] = $form->createView();
            }
        }
        $formulaire = $this->createForm(FormulaireType::class, $commande , ['departement'=>$commande->DEPARTMENTS]);
        $form->submit($request->request->all());
        $formDivn->submit($request->request->all());
        $formulaire->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid() || $formulaire->isSubmitted() && $formulaire->isValid()) {
            
            $sessionManager->initSession();

            $tmsInfoImmat = $commandeManager->tmsInfoImmat($commande);
            if (!$tmsInfoImmat->isSuccessfull()) {
                throw new \Exception('Veuillez Réessayer plus tard');
            }
            $tmsResponse = $commandeManager->tmsEnvoyer($commande, $tmsInfoImmat);
            if (!$tmsResponse->isSuccessfull()) {
                return new Response($tmsResponse->getErrorMessage());
            } else {
                $taxe = $taxesManager->createFromTmsResponse($tmsResponse, $commande, $tmsInfoImmat);
                $carInfo = $carInfoManager->createInfoFromTmsImmatResponse($tmsInfoImmat);
                $commande->setTaxes($taxe);
                $commande->setCarInfo($carInfo);
                $manager->persist($commande);
                $manager->persist($taxe);

                $manager->flush();

                // The Publisher service is an invokable object
                // $data = [
                //         'immat' => $commande->getImmatriculation(),
                //         'department' => $commande->getCodePostal(),
                //         'demarche' => $commande->getDemarche()->getType(),
                //         'id' => $commande->getId(),
                // ];
                // $mercureManager->publish(
                //     'http://cgofficiel.com/addNewSimulator',
                //     'commande',
                //     $data,
                //     'new Simulation is insert'
                // );

                // $notificationManager->saveNotification([
                //     "type" => 'commande', 
                //     "data" => $data,
                // ]);
                $this->saveToSession($commande, $sessionManager, $tabForm);

                return $this->json($commande, 200, [], ['groups' => 'api']);
            }
        }      

        return new JsonResponse([
            'errors' => 'Une erreur s\'est produite'
        ]);
    }

    /**
     * @Route("/simulation_error", name="error_simulation")
     */
    public function errorSimulation()
    {
        return $this->render('home/error/error_simulation.html.twig', []);
    }
}
