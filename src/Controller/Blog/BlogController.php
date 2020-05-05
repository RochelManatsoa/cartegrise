<?php

namespace App\Controller\Blog;


use App\Entity\{Demande, ContactUs, Commande, Taxes, TypeDemande, DivnInit, User};
use App\Form\{DemandeType, CommandeType, ContactUsType, FormulaireType};
use App\Repository\{CommandeRepository, TaxesRepository, TarifsPrestationsRepository, DemandeRepository, TypeDemandeRepository};
use App\Services\Tms\TmsClient;
use App\Manager\{SessionManager, CommandeManager, TaxesManager, CarInfoManager, DivnInitManager, ContactUsManager, NotificationManager};
use App\Form\DivnInitType;
use App\Manager\Mercure\MercureManager;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use App\Entity\Blog\{Article, Categorie, Commentaire};
use App\Form\Blog\{CommentaireType, BlogSearchType};
use App\Manager\Blog\{BlogManager, SearchManager};
use App\Manager\Blog\Modele\BlogSearch;
use App\Repository\Blog\{ArticleRepository, CategorieRepository, FaqRepository};
use Doctrine\ORM\EntityManagerInterface as ObjectManager;
use http\Env\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends Controller
{
    
    /**
     * @Route("/", name="blog")
     */
    public function index(
            ArticleRepository $repository,
            Blogmanager $blogManager,
            Request $request,
            SearchManager $searchManager,
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
            $divnInit = $formDivn->getData();
            $divnInitManager->manageSubmit($divnInit);
            $param = $this->getParamHome($divnInit->getCommande(), $sessionManager, $tabForm);

            return $this->render('home/accueil.html.twig', $param);
        }


        if ($form->isSubmitted() && $form->isValid() || $formulaire->isSubmitted() && $formulaire->isValid()) {
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

                    // The Publisher service is an invokable object
                    $data = [
                            'immat' => $commande->getImmatriculation(),
                            'department' => $commande->getCodePostal(),
                            'demarche' => $commande->getDemarche()->getType(),
                            'id' => $commande->getId(),
                    ];
                    $mercureManager->publish(
                        'http://cgofficiel.com/addNewSimulator',
                        'commande',
                        $data,
                        'new Simulation is insert'
                    );

                    $notificationManager->saveNotification([
                        "type" => 'commande', 
                        "data" => $data,
                    ]);
                    $this->saveToSession($commande, $sessionManager, $tabForm);
                    return $this->redirectToRoute('commande_recap', ['commande'=> $commande->getId()]);

                    // $param = $this->getParamHome($commande, $sessionManager, $tabForm);

                    // return $this->render('home/accueil.html.twig', $param);
                }
            // }
        }

        $homeParams = [
            'demarches' => $type,
            'tab' => $tabForm,
            'formulaire' => $formulaire->createView(),
            'database' => false,
        ];

        $repo = $repository->findBy(
                ['publication' => true],
                ['date' => 'DESC']
            );
        // @var $paginator \Knp\Component\Pager\Paginator 
        $search = new BlogSearch();
        $formSearch = $this->createForm(BlogSearchType::class, $search);
        $paginator = $this->get('knp_paginator');
        $articles = $paginator->paginate(
            $repo, $request->query->getInt('page', 1), 6
            );
        $params = $blogManager->getCatAndFaq();
        $params = array_merge(['articles'=>$articles], $params);
        $params = array_merge(['formSearch'=>$formSearch->createView()], $params);
        $params = array_merge($homeParams, $params);
        $formSearch->handleRequest($request);
        if($formSearch->isSubmitted() && $formSearch->isValid()){
            $search = $formSearch->getData();
            $results = $searchManager->search($search);
            $params = array_merge(['results'=>$results], $params);

            return $this->render('blog/result.html.twig', $params);
        }

        return $this->render('blog/index.html.twig', $params);
    }

    /**
     * @Route("/{slug}", name="blog_show")
     */
    public function show(
        Article $article, 
        Request $request, 
        BlogManager $blogManager,
        SearchManager $searchManager,
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
            $divnInit = $formDivn->getData();
            $divnInitManager->manageSubmit($divnInit);
            $param = $this->getParamHome($divnInit->getCommande(), $sessionManager, $tabForm);

            return $this->render('home/accueil.html.twig', $param);
        }


        if ($form->isSubmitted() && $form->isValid() || $formulaire->isSubmitted() && $formulaire->isValid()) {
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

                    // The Publisher service is an invokable object
                    $data = [
                            'immat' => $commande->getImmatriculation(),
                            'department' => $commande->getCodePostal(),
                            'demarche' => $commande->getDemarche()->getType(),
                            'id' => $commande->getId(),
                    ];
                    $mercureManager->publish(
                        'http://cgofficiel.com/addNewSimulator',
                        'commande',
                        $data,
                        'new Simulation is insert'
                    );

                    $notificationManager->saveNotification([
                        "type" => 'commande', 
                        "data" => $data,
                    ]);
                    $this->saveToSession($commande, $sessionManager, $tabForm);
                    return $this->redirectToRoute('commande_recap', ['commande'=> $commande->getId()]);

                    // $param = $this->getParamHome($commande, $sessionManager, $tabForm);

                    // return $this->render('home/accueil.html.twig', $param);
                }
            // }
        }

        $homeParams = [
            'demarches' => $type,
            'tab' => $tabForm,
            'formulaire' => $formulaire->createView(),
            'database' => false,
        ];

        $post = $blogManager->findArticleSimilaire($article);
        $comment = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $comment);
        $search = new BlogSearch();
        $formSearch = $this->createForm(BlogSearchType::class, $search);

        $params = $blogManager->getCatAndFaq();
        $params = array_merge(['prev'=>$blogManager->findPreviousPost($article)], $params);
        $params = array_merge(['next'=>$blogManager->findNextPost($article)], $params);
        $params = array_merge(['post'=>$post], $params);
        $params = array_merge(['recentPost'=> 'recentPost'], $params);
        $params = array_merge(['article'=>$article], $params);
        $params = array_merge(['formComment'=>$form->createView()], $params);
        $params = array_merge(['formSearch'=>$formSearch->createView()], $params);
        $params = array_merge($homeParams, $params);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setDate(new \DateTime())
                    ->setArticle($article)
                    ->setPublication(false);
            $blogManager->save($comment);
            $this->addFlash('success', 'Votre commentaire à bien été enregistré.');
            $params = array_merge(['slug'=>$article->getSlug()], $params);

            return $this->redirectToRoute('blog_show', ['slug'=>$article->getSlug()]);
        }
        $formSearch->handleRequest($request);
        if($formSearch->isSubmitted() && $formSearch->isValid()){
            $search = $formSearch->getData();
            $results = $searchManager->search($search);
            $params = array_merge(['results'=>$results], $params);

            return $this->render('blog/result.html.twig', $params);
        }
        
        return $this->render('blog/show.html.twig', $params);
    }

    /**
     * @Route("/categorie/{slug}", name="show_cat")
     */
    public function showCat(
        Categorie $categorie, 
        ArticleRepository $repository, 
        Request $request,
        BlogManager $blogManager,
        SearchManager $searchManager,
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
            $divnInit = $formDivn->getData();
            $divnInitManager->manageSubmit($divnInit);
            $param = $this->getParamHome($divnInit->getCommande(), $sessionManager, $tabForm);

            return $this->render('home/accueil.html.twig', $param);
        }


        if ($form->isSubmitted() && $form->isValid() || $formulaire->isSubmitted() && $formulaire->isValid()) {
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

                    // The Publisher service is an invokable object
                    $data = [
                            'immat' => $commande->getImmatriculation(),
                            'department' => $commande->getCodePostal(),
                            'demarche' => $commande->getDemarche()->getType(),
                            'id' => $commande->getId(),
                    ];
                    $mercureManager->publish(
                        'http://cgofficiel.com/addNewSimulator',
                        'commande',
                        $data,
                        'new Simulation is insert'
                    );

                    $notificationManager->saveNotification([
                        "type" => 'commande', 
                        "data" => $data,
                    ]);
                    $this->saveToSession($commande, $sessionManager, $tabForm);
                    return $this->redirectToRoute('commande_recap', ['commande'=> $commande->getId()]);

                    // $param = $this->getParamHome($commande, $sessionManager, $tabForm);

                    // return $this->render('home/accueil.html.twig', $param);
                }
            // }
        }

        $homeParams = [
            'demarches' => $type,
            'tab' => $tabForm,
            'formulaire' => $formulaire->createView(),
            'database' => false,
        ];

        $repo = $repository->findByCatagories($categorie->getId());
        $search = new BlogSearch();
        $formSearch = $this->createForm(BlogSearchType::class, $search);
        /* @var $paginator \Knp\Component\Pager\Paginator */
        $paginator = $this->get('knp_paginator');
        $articles = $paginator->paginate(
            $repo, $request->query->getInt('page', 1), 6
        );
        $params = $blogManager->getCatAndFaq();
        $params = array_merge(['articles'=>$articles], $params);
        $params = array_merge(['categorie'=>$categorie], $params);
        $params = array_merge(['formSearch'=>$formSearch->createView()], $params);
        $params = array_merge($homeParams, $params);
        $formSearch->handleRequest($request);
        if($formSearch->isSubmitted() && $formSearch->isValid()){
            $search = $formSearch->getData();
            $results = $searchManager->search($search);
            $params = array_merge(['results'=>$results], $params);

            return $this->render('blog/result.html.twig', $params);
        }
        
        return $this->render('blog/categorie.html.twig', $params);
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
}
