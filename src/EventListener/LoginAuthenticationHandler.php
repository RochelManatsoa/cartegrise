<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-05-21 10:55:09 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2020-07-29 08:52:20
 */
namespace App\EventListener;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use App\Manager\{UserManager, SessionManager};
use App\Entity\Systempay\Transaction;
use App\Entity\Commande;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginAuthenticationHandler implements AuthenticationSuccessHandlerInterface
{
    private $routerInterface;
    private $userManager;
    private $sessionManager;

    /**
     * Constructor function
     *
     * @param RouterInterface $routerInterface
     * @param UserManager $userManager
     * @param SessionManager $sessionManager
     */
    public function __construct(
        RouterInterface $routerInterface,
        UserManager $userManager,
        SessionManager $sessionManager
        )
    {
        $this->routerInterface = $routerInterface;
        $this->userManager = $userManager;
        $this->sessionManager = $sessionManager;
    }
    /**
     * OnSecurityInteractiveLogin function
     *
     * @param InteractiveLoginEvent $event
     * @return void
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $token = $event->getAuthenticationToken();
        $request = $event->getRequest();
        $this->onAuthenticationSuccess($request, $token);
    }
    /**
     * onAuthenticationSuccess function
     *
     * @param Request $request
     * @param TokenInterface $token
     * @return void
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();

        //$this->getUrlContent("http://dev3.cgofficiel.fr/account/connect-this-user/".$user->getId());
        if($user->hasRole("ROLE_USER") && !$user->hasRole("ROLE_ADMIN_BLOG") && !$user->hasRole("ROLE_CRM") && !$user->hasRole("ROLE_BANNED")) {
            $this->userManager->checkCommandeInSession($user);
            $lastCommandPayed = $this->userManager->getLastCommandePayed($user);
            if ($lastCommandPayed instanceof Commande) {
                return new RedirectResponse($this->routerInterface->generate('new_demande', ["commande" => $lastCommandPayed->getId()]));
            }
        }elseif($user->hasRole("ROLE_ADMIN_BLOG")){

            return new RedirectResponse($this->routerInterface->generate('easyadmin'));
        }elseif ($user->hasRole("ROLE_CRM")) {
            return new RedirectResponse($this->routerInterface->generate('route_crm_home'));
        }elseif ($user->hasRole("ROLE_BANNED")) {
            return new RedirectResponse($this->routerInterface->generate('fos_user_security_logout'));
        }
        $this->userManager->checkCommandeInSession($user);

        return new RedirectResponse($this->routerInterface->generate('espace_client'));
    }

    private function getUrlContent($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpcode>=200 && $httpcode<300) ? $data : false;
    }
}