<?php

namespace App\Controller;

use KleeGroup\FranceConnectBundle\Manager\ContextService;
use KleeGroup\FranceConnectBundle\Manager\ContextServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Manager\{UserManager, SessionManager};

/**
 * Class FranceConnectController
 *
 * @package KleeGroup\FranceConnectBundle\Controller
 * @Route("/france-connect")
 */
class FranceConnectController extends Controller
{
    /** @var LoggerInterface */
    private $logger;

    /** @var ContextServiceInterface */
    private $contextService;
    private $sessionManager;
    private $userManager;
    

    public function __construct(
        LoggerInterface $logger, 
        ContextServiceInterface $contextService,
        UserManager $userManager,
        SessionManager $sessionManager
    )
    {
        $this->logger = $logger;
        $this->contextService = $contextService;
        $this->sessionManager = $sessionManager;
        $this->userManager = $userManager;
        
    }
    
    /**
     * @Route("/login_fc", methods="GET", name="france_connect_login")
     * @return RedirectResponse
     */
    public function loginAction( )
    {
        $this->logger->debug('Generating a URL to get the authorization code.');
        $url = $this->contextService->generateAuthorizationURL();
        
        return $this->redirect($url);
    }
    
    /**
     * @Route("/callback", methods="GET")
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function checkAction(Request $request)
    {
        $this->logger->debug('Callback intercept.');
        $getParams = $request->query->all();
        $this->contextService->getUserInfo($getParams);
        switch ($this->getParameter('france_connect.result_type')) {
            case 'route' :
                $redirection = $this->redirectToRoute($this->getParameter('france_connect.result_value'));
                break;
            default :
                $redirection = $this->redirect($this->getParameter('france_connect.result_value'));
                break;
        }

        return $redirection;
    }
    
    /**
     * @Route("/logout_fc")
     * @return RedirectResponse
     */
    public function logoutAction()
    {
        $this->logger->debug('Get Logout URL.');
        $url = $this->contextService->generateLogoutURL();
        
        return $this->redirect($url);
    }

    /**
    * @param Request $request
    * @Route("/france-connect-traitement", name="app.fc.return")
    * @Security("is_granted('IS_FRANCE_CONNECT_AUTHENTICATED')")
    */
   public function franceConnectAction(Request $request, UserManager $userManager)
   {
       $token = $this->get('security.token_storage')->getToken();
       $identity = $token->getIdentity(); // json array provided by FranceConnect 
       //check if email exist
       $ifUser = $userManager->checkEmail($identity["email"]);
        if ($ifUser) {
            $user = $ifUser;
        } else {
            $user = $userManager->createUserFranceConnect($identity);
        }
        $userManager->connect($user);
        // add commande in user
        $idsRecapCommande = $request->getSession()->get(SessionManager::IDS_COMMANDE);
        $this->userManager->addCommandeInSession($user, $idsRecapCommande);
        $this->sessionManager->remove(SessionManager::IDS_COMMANDE);
        //end add commande in user
        
        return $this->redirectToRoute($this->getParameter('france_connect.logout_value'));
   }

   /**
    * to simulate FranceConnect and don't touche please
    * @Route("/simulator", name="simulator")
    */
   public function simulatorFranceConnect(Request $request, UserManager $userManager)
   {
       $identity =             
        [
            "sub" => "fc3b3f9c24b0b2d0e9c52b41576c23ffd7b6deb2c8fc322c2d58bb6101e3ac18v1",
            "birthcountry" => "99100",
            "birthplace" => "95277",
            "given_name" => "Mélaine Évelyne",
            "family_name" => "TROIS",
            "gender" => "female",
            "birthdate" => "1981-07-27",
            "preferred_username" => "TROIS",
            "phone_number" => "0123456789",
            "email" => "trois_melaine@mail.com",
            "address" => [
                "country" => "France",
                "formatted" => "France Marseille 13016 97 Boulevard François Robert",
                "locality" => "Marseille",
                "postal_code" => "13016",
                "street_address" => "97 Boulevard François Robert",
            ],
            "access_token" => "c69b175100e36ea745a29a92437604e78d9c92770b697f99afebe2aca75e5ef0",
        ];
    $ifUser = $userManager->checkEmail($identity["email"]);
    // $em = $this->getDoctrine()->getManager();
    // $em->remove($ifUser);
    // $em->flush();
    // echo 'vita';die;
    if ($ifUser) {
        $user = $ifUser;
    } else {
        $user = $userManager->createUserFranceConnect($identity);
    }
    $userManager->connect($user);
    // add commande in user
    $idsRecapCommande = $request->getSession()->get(SessionManager::IDS_COMMANDE);
    $this->userManager->addCommandeInSession($user, $idsRecapCommande);
    $this->sessionManager->remove(SessionManager::IDS_COMMANDE);
    //end add commande in user
    
    return $this->redirectToRoute($this->getParameter('france_connect.logout_value'));
   }
    
    
}
