<?php

namespace App\Manager;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\{User, Client, Contact, Adresse, Commande};
use App\Manager\SessionManager;
use App\Manager\MailManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommandeRepository;
class UserManager
{
    private $repository;
    private $em;
    private $token;
    private $session;
    private $sessionManager;
    private $encoder;
    private $commandeRepository;
    private $mailManager;
    public function __construct(
        EntityManagerInterface $em,
        UserRepository $repository,
        TokenStorageInterface $token,
        SessionManager $sessionManager,
        UserPasswordEncoderInterface $encoder,
        CommandeRepository $commandeRepository,
        MailManager $mailManager
    )
    {
        $this->repository = $repository;
        $this->em         = $em;
        $this->token      = $token;
        $this->session    = $sessionManager->initSession();
        $this->sessionManager    = $sessionManager;
        $this->encoder    = $encoder;
        $this->commandeRepository    = $commandeRepository;
        $this->mailManager    = $mailManager;
    }
    public function countDemande(User $user)
    {
        return $this->repository->countDemande($user);
    }
    
    public function checkDemande(User $user)
    {
        return $this->repository->checkDemande($user);
    }

    public function countCommandeUnchecked(User $user)
    {
        return $this->repository->countCommandeUnchecked($user);
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
            $this->save($user);
            $this->sessionManager->remove(SessionManager::IDS_COMMANDE);
        }
    }

    public function checkCommandeInSession(User $user)
    {
        $idsRecapCommande = $this->sessionManager->get(SessionManager::IDS_COMMANDE);
        if (!is_null($idsRecapCommande)) {
            foreach ($idsRecapCommande as $idRecapCommande){
                if (is_integer($idRecapCommande)){
                    $commande = $this->commandeRepository->find($idRecapCommande);
                    if (!$commande instanceof Commande) {
                        return;
                    }
                    $user->getClient()->addCommande($commande);
                    $user->getClient()->setCountCommande($user->getClient()->getCountCommande() + 1);
                }
            }
            $this->save($user);
            $this->sessionManager->remove(SessionManager::IDS_COMMANDE);
        }
    }

    public function save(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function saveOther($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
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

    public function sendUserForRelance($level = 0)
    {
        $users = $this->repository->findUserForRelance($level);
        // dd($users);
        $template = 'relance/email1.html.twig';
        $emails = [];
        foreach ($users as $user)
        {
            $this->mailManager->sendEmail($emails=[$user->getEmail()], $template, "CG Officiel - Démarches Carte Grise en ligne", ['responses'=> $user]);
            $user->getClient()->setRelanceLevel($level+1);
            $this->em->persist($user);
        }
        $this->em->flush();
        
        return 'sended';
    }

    public function getUserByEmail(string $email) :?User
    {
        return $this->repository->findOneBy(['email'=>$email]);
    }

    public function getRepository() :UserRepository
    {
        return $this->repository;
    }

    public function sendEmailOnRegistration($user)
    {
        $template = 'email/register.mail.twig';
        $this->mailManager->sendEmail([$user->getEmail()], $template, "Bienvenue sur CG Officiel - Démarches Carte Grise en ligne", ['responses'=> $user]);
        return 'success';
    }

    public function getLastCommandePayed(User $user)
    {
        return $this->commandeRepository->getLastCommandePayed($user);
    }
}