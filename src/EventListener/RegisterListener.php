<?php

namespace App\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Repository\CommandeRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Manager\SessionManager;
use App\Manager\UserManager;
use App\Manager\Mercure\MercureManager;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class RegisterListener implements EventSubscriberInterface
{
    private $router;
    private $commandeRepository;
    private $em;
    private $sessionManager;
    private $userManager;
    private $mercureManager;

    public function __construct(
        UrlGeneratorInterface $router, 
        CommandeRepository $commandeRepository, 
        EntityManagerInterface $em,
        SessionManager $sessionManager,
        UserManager $userManager,
        MercureManager $mercureManager
    )
    {
        $this->router             = $router;
        $this->commandeRepository = $commandeRepository;
        $this->em                 = $em;
        $this->sessionManager     = $sessionManager;
        $this->userManager     = $userManager;
        $this->mercureManager     = $mercureManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_COMPLETED  => 'onRegistrationCompleted',
        );
    }

    public function onRegistrationCompleted(FilterUserResponseEvent $event)
    {
        $user = $event->getUser();
        if (!$user instanceof User)
            return;
        $this->userManager->checkCommandeInSession($user);
        // The Publisher service is an invokable object
        $this->mercureManager->publish(
        'http://cgofficiel.com/addNewSimulator',
        'utilisateur',
        [],
        'nouvelle Utilisateur insérer'
        );
        
        return;
    }
}