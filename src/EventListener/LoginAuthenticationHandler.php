<?php
namespace App\EventListener;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginAuthenticationHandler implements AuthenticationSuccessHandlerInterface
{
    private $routerInterface;
    public function __construct(RouterInterface $routerInterface){
        $this->routerInterface = $routerInterface;
    }
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $token = $event->getAuthenticationToken();
        $request = $event->getRequest();
        $this->onAuthenticationSuccess($request, $token);
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();
        if ($user->hasRole("ROLE_CRM")) {

            return new RedirectResponse($this->routerInterface->generate('home_crm'));
        }

        return new RedirectResponse($this->routerInterface->generate('Accueil'));
    }
}