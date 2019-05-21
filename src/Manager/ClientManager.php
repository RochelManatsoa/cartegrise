<?php

/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-05-21 11:00:30 
 * @Last Modified by:   Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Last Modified time: 2019-05-21 11:00:30 
 */

namespace App\Manager;

use App\Repository\ClientRepository;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\{User, Client, Contact, Adresse};
use App\Manager\SessionManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommandeRepository;

class ClientManager
{
    private $repository;
    private $em;
    private $token;
    private $session;
    private $encoder;
    private $commandeRepository;
    public function __construct(
        EntityManagerInterface $em,
        ClientRepository $repository,
        TokenStorageInterface $token,
        SessionManager $sessionManager,
        UserPasswordEncoderInterface $encoder,
        CommandeRepository $commandeRepository 
    )
    {
        $this->repository = $repository;
        $this->em         = $em;
        $this->token      = $token;
        $this->session    = $sessionManager->initSession();
        $this->encoder    = $encoder;
        $this->commandeRepository    = $commandeRepository;
    }

    public function addCommandeInSession(Client $client, $idsRecapCommande)
    {
        if (!is_null($idsRecapCommande)) {
            foreach ($idsRecapCommande as $idRecapCommande){
                if (is_integer($idRecapCommande)){
                    $commande = $this->commandeRepository->find($idRecapCommande);
                    $client->addCommande($commande);
                }
            }
            $this->save($client);
        }
    }

    public function save(Client $client)
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}