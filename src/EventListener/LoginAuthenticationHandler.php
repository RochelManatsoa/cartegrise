<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-05-21 10:55:09 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-12-31 08:46:38
 */
namespace App\EventListener;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use App\Manager\{UserManager, SessionManager};
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
        if ($user->hasRole("ROLE_CRM")) {
            return new RedirectResponse($this->routerInterface->generate('route_crm_home'));
        } elseif(!$user->hasRole("ROLE_CRM")) {
            $this->userManager->checkCommandeInSession($user);
            $commandes = $user->getClient()->getCommandes();
            if (!is_null($commandes) && 0 < count($commandes)){
                $lastCommande = $commandes->last();
                // add condition when user went to recap before
                if ( 
                    null === $lastCommande->getTransaction() ||
                        (null !== $lastCommande->getTransaction() &&
                        $lastCommande->getTransaction()->getStatus() != '00')
                ) {
                    return new RedirectResponse($this->routerInterface->generate('commande_recap', ["commande" => $lastCommande->getId()]));
                }
            }

        }
        $this->userManager->checkCommandeInSession($user);

        return new RedirectResponse($this->routerInterface->generate('espace_client'));
    }
}