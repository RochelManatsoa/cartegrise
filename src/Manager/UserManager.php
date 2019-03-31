<?php

namespace App\Manager;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\{User, Client, Contact, Adresse};
use App\Manager\SessionManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommandeRepository;

class UserManager
{
    private $repository;
    private $em;
    private $token;
    private $session;
    private $encoder;
    private $commandeRepository;
    public function __construct(
        EntityManagerInterface $em,
        UserRepository $repository,
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
    public function countDemande(User $user)
    {
        return $this->repository->countDemande($user);
    }

    public function checkEmail($email)
    {
        return $this->repository->findOneBy(['email' => $email]);
    }

    public function connect(User $user)
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->token->setToken($token);
    }

    public function addCommandeInSession(User $user, $idsRecapCommande)
    {
        if (!is_null($idsRecapCommande)) {
            foreach ($idsRecapCommande as $idRecapCommande){
                if (is_integer($idRecapCommande)){
                    $commande = $this->commandeRepository->find($idRecapCommande);
                    $user->getClient()->addCommande($commande);
                }
            }
            $this->em->persist($user);
            $this->em->flush();
        }
    }

    public function createUserFranceConnect(array $identity) : User
    {
        $user     = new User();
        $client   = new Client();
        $pass     = $identity["family_name"] . (new \DateTime())->getTimestamp();
        $realPass = $this->encoder->encodePassword($user, $pass);
        $user->setUsername(isset($identity["preferred_username"]) ? $identity["preferred_username"] : $pass)
             ->setEmail($identity["email"])->setEnabled(true)->setFranceConnectId($identity["sub"])
             ->setPassWord($realPass);
        $client->setClientNom($identity["family_name"])->setClientPrenom($identity["given_name"])->setClientNomUsage($identity["family_name"])
             ->setClientGenre($identity["gender"] === "female" ? "Mme" : "M")->setUser($user)->setClientDptNaissance($identity["birthplace"])
             ->setClientDateNaissance(new \DateTime($identity["birthdate"]))->setClientLieuNaissance($identity["birthplace"])
             ->setClientPaysNaissance($identity["birthcountry"]);
        if (isset($identity["phone_number"]) && is_array($identity["phone_number"])) {
            $contact  = new Contact();
            $client->setClientContact($contact);
            $contact->setContactTelmobile($identity["phone_number"])->setContactTelfixe($identity["phone_number"]);
        }
        if (isset($identity["address"]) && is_array($identity["address"])) {
            $adresse  = new Adresse();
            $adresse->setVille($identity["address"]["locality"])->setLieudit($identity["address"]["formatted"])
                    ->setCodepostal($identity["address"]["postal_code"])->setPays($identity["address"]["country"])
                    ->setAdprecision($identity["address"]["street_address"])->setClient($client);
        }

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}