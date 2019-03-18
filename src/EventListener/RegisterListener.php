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

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class RegisterListener implements EventSubscriberInterface
{
    private $router;
    private $commandeRepository;
    private $em;

    public function __construct(UrlGeneratorInterface $router, CommandeRepository $commandeRepository, EntityManagerInterface $em)
    {
        $this->router             = $router;
        $this->commandeRepository = $commandeRepository;
        $this->em                 = $em;
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
        $idsRecapCommande = $event->getRequest()->getSession()->get(SessionManager::IDS_COMMANDE);
        $user = $event->getUser();
        if (!$user instanceof User)
            return;
        if (!is_null($idsRecapCommande)) {
            foreach ($idsRecapCommande as $idRecapCommande){
                $commande = $this->commandeRepository->find($idRecapCommande);
                $user->getClient()->addCommande($commande);
            }
            $this->em->persist($user);
            $this->em->flush();
            $event->getRequest()->getSession()->remove(SessionManager::IDS_COMMANDE);
        }
        
        return;
    }
}