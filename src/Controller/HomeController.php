<?php

namespace App\Controller;

use App\Entity\{Demande, ContactUs, Commande, Taxes, TypeDemande, DivnInit};
use App\Form\{DemandeType, CommandeType, ContactUsType};
use App\Repository\{CommandeRepository, TaxesRepository, TarifsPrestationsRepository, DemandeRepository, TypeDemandeRepository};
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Tms\TmsClient;
use App\Manager\{SessionManager, CommandeManager, TaxesManager, CarInfoManager, DivnInitManager, ContactUsManager};
use App\Form\DivnInitType;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="Accueil")
     * @Route("/", name="home")
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
        CarInfoManager $carInfoManager,
        TaxesManager $taxesManager,
        DivnInitManager $divnInitManager
        )
    {   
        
        $type = $demarche->findAll();
        foreach($type as $typeId) {
            $commande = $commandeManager->createCommande();
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

        $form->handleRequest($request);
        $formDivn->handleRequest($request);

        if ($formDivn->isSubmitted() && $formDivn->isValid()) {
            $divnInit = $formDivn->getData();
            $divnInitManager->manageSubmit($divnInit);
            $param = $this->getParamHome($divnInit->getCommande(), $sessionManager, $tabForm);

            return $this->render('home/accueil.html.twig', $param);
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $ifCommande = $commandeRepository->findOneBy([
                'immatriculation' => $commande->getImmatriculation(),
                'codePostal' => $commande->getCodePostal(),
                'demarche' => $commande->getDemarche(),
            ]);
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
                    $param = $this->getParamHome($commande, $sessionManager, $tabForm);

                    return $this->render('home/accueil.html.twig', $param);
                }
            // }
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
        $taxe = $commande->getTaxes();
        $majoration = 0;
        $param = [
            'commande' => $commande, 'recap' => $commande,
            'taxe' => $taxe,        'database' => true,   'majoration' => $majoration,
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
     * @Route("/CommentCaMarche", name="CommentCaMarche")
     */
    public function CommentCaMarche()
    {
        return $this->render('home/CommentCaMarche.html.twig');
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faq()
    {
        return $this->render('home/faq.html.twig');
    }

	/**
	 * @Route("/CGV", name="cgv")
	 */
	public function cgv()
	{
		return $this->render('home/cgv.html.twig');
	}

	/**
	 * @Route("/retractation", name="retractation")
	 */
	public function retractation()
	{
        return $this->render('home/retractation.html.twig');
	}

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, ContactUsManager $contactUsManger)
    {
        $contactU = new ContactUs();
        $form = $this->createForm(ContactUsType::class, $contactU);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $contactUsManger->save($data);

            return $this->redirectToRoute('home');
        }

        return $this->render('home/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/prix-carte-grise", name="prix_carte_grise")
     */
    public function accueilSimulator()
    {   
        return $this->render('home/prix.html.twig');
    }
}
