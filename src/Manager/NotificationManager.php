<?php

namespace App\Manager;

use App\Repository\{NotificationRepository, CommandeRepository, DemandeRepository};
use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;

class NotificationManager
{
    private $repository;

    public function __construct(
        NotificationRepository $repository,
        CommandeRepository $commandeRepository,
        DemandeRepository $demandeRepository,
        EntityManagerInterface $em
    ) {
        $this->em = $em;
        $this->repository = $repository;
        $this->commandeRepository = $commandeRepository;
        $this->demandeRepository = $demandeRepository;
    }
    
    public function saveNotification(array $data){
        switch($data['type']) {
            case 'utilisateur': 
                // $this->saveNotificationUser($data);
            case 'commande': 
                $this->saveNotificationCommande($data);
            break;
            case 'demande': 
                $this->saveNotificationDemande($data);
            break;
            default: 
                return null;
        break;
        }
    }

    public function saveNotificationCommande(array $infosCommande)
    {
        $notification = new Notification();
        $commande = $this->commandeRepository->find($infosCommande['data']['id']);
        $notification->setCommande($commande);
        $notification->setContent(json_encode($infosCommande));
        $notification->setSubject('Nouvelle Commande');
        $this->save($notification);
    }

    public function saveNotificationDemande(array $infosCommande)
    {
        $notification = new Notification();
        $demande = $this->demandeRepository->find($infosCommande['data']['id']);
        $notification->setDemande($demande);
        $notification->setContent(json_encode($infosCommande));
        $notification->setSubject('Nouvelle Demande');
        $this->save($notification);
    }

    public function saveNotificationUser(array $infosCommande)
    {
        $notification = new Notification();
        $user = $this->userRepository->find($infosCommande['data']['id']);
        $notification->setUser($user);
        $notification->setContent(json_encode($infosCommande));
        $notification->setSubject('Nouvelle Utilisateur');
        $this->save($notification);
    }

    private function save(Notification $notification)
    {
        $this->em->persist($notification);
        $this->em->flush();
    }

}