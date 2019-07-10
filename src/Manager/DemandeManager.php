<?php

/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-17 13:14:01 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-07-04 12:21:39
 */
namespace App\Manager;

use App\Entity\Commande;
use App\Entity\Demande;
use App\Entity\Transaction;
use App\Entity\TypeDemande;
use App\Entity\User;
use App\Form\Demande\DemandeCtvoType;
use App\Form\Demande\DemandeDivnType;
use App\Form\Demande\DemandeCessionType;
use App\Form\Demande\DemandeDuplicataType;
use App\Form\Demande\DemandeChangementAdresseType;
use App\Form\DocumentDemande\DemandeNonValidateType;
use App\Manager\{TransactionManager, MailManager};
use App\Repository\DemandeRepository;
use App\Manager\ClientManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Knp\Snappy\Pdf;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig_Environment as Twig;

class DemandeManager
{
    private $em;
    private $formFactory;
    private $twig;
    private $repository;
    private $transactionManager;
    private $translator;
    private $commandeManager;
    private $clientManager;
    private $tokenStorage;

    public function __construct
    (
        EntityManagerInterface $em,
        FormFactoryInterface   $formFactory,
        Twig                   $twig,
        DemandeRepository      $repository,
        TransactionManager     $transactionManager,
        TranslatorInterface    $translator,
        CommandeManager        $commandeManager,
        TokenStorageInterface  $tokenStorage,
        ClientManager          $clientManager
    )
    {
        $this->em                 = $em;
        $this->formFactory        = $formFactory;
        $this->twig               = $twig;
        $this->repository         = $repository;
        $this->transactionManager = $transactionManager;
        $this->commandeManager    = $commandeManager;
        $this->translator         = $translator;
        $this->tokenStorage       = $tokenStorage;
        $this->clientManager      = $clientManager;
    }

    private function init()
    {
        return new Demande();
    }

    public function generateForm(Commande $commande)
    {
        $demande = $this->init();
        $commande->setDemande($demande);
        switch ($commande->getDemarche()->getType()) {
            case "CTVO":
                $form = $this->formFactory->create(DemandeCtvoType::class, $demande);
            break;
            
            case "DUP":
                $form = $this->formFactory->create(DemandeDuplicataType::class, $demande);
            break;

            case "DIVN":
                $form = $this->formFactory->create(DemandeDivnType::class, $demande);
            break;

            case "DC":
                $form = $this->formFactory->create(DemandeCessionType::class, $demande);
            break;
            
            case "DCA":
                $form = $this->formFactory->create(DemandeChangementAdresseType::class, $demande);
                break;
        }
        
        return $form;
    }

    public function generateFormDeniedFiles(Demande $demande)
    {
        $demande->setMotifDeRejet('')->setChecker(null);
        return $this->formFactory->create(DemandeNonValidateType::class, $demande);
    }

    public function save(Form $form)
    {
        $demande = $form->getData();
        $this->saveDemande($demande);

        return $demande;

    }

    public function saveDemande(Demande $demande)
    {
        if (!$demande instanceof Demande)
            return;
        $this->em->persist($demande);
        $this->em->flush();
    }

    public function getView(Form $form)
    {
        $demande = $form->getData();
        switch($demande->getCommande()->getDemarche()->getType()) {
            case "CTVO":
                $view = $this->twig->render(
                        "demande/ctvo.html.twig",
                        [
                            'form'     => $form->createView(),
                            'commande' => $demande->getCommande(),
                        ]
                );
            break;

            case "DUP":
                $view = $this->twig->render(
                        "demande/duplicata.html.twig",
                        [
                            'form'     => $form->createView(),
                            'commande' => $demande->getCommande(),
                        ]
                );
            break;

            case "DIVN":
                $view = $this->twig->render(
                        "demande/divn.html.twig",
                        [
                            'form'     => $form->createView(),
                            'commande' => $demande->getCommande(),
                        ]
                );
                break;
            
            case "DCA":
                $view = $this->twig->render(
                        "demande/changementAdresse.html.twig",
                        [
                            'form'     => $form->createView(),
                            'commande' => $demande->getCommande(),
                        ]
                );
            break;

            case "DC":
                $view = $this->twig->render(
                        "demande/cession.html.twig",
                        [
                            'form'     => $form->createView(),
                            'commande' => $demande->getCommande(),
                        ]
                );
            break;
        }

        return $view;
    }

    public function countDemandeOfUser(User $user)
    {
        return $this->repository->countDemandeForUser($user)[1];
    }

    public function getDemandeOfUser(User $user)
    {
        return $this->repository->getDemandeForUser($user);
    }

    public function checkPayment(Demande $demande)
    {
        // if (!$demande->getTransaction() instanceof Transaction) {
            $transaction = $this->transactionManager->init();
            $demande->setTransaction($transaction);
            $transaction->setDemande($demande);
            $this->saveDemande($demande);
        // } 
    }

    public function getDossiersAFournir(Demande $demande, $pathCerfa="")
    {
        $typeDemande = $demande->getCommande()->getDemarche()->getType();

        if (in_array($typeDemande, TypeDemande::TYPE_CHOICES)) {
            return $this->translator->trans('type_demande.daf.' . strtolower($typeDemande), ['$cerfa'=>$pathCerfa]);
        }

        return '';
    }

    public function removeDemande(Demande $demande)
    {
        if ($duplicata = $demande->getDuplicata()) {
            $duplicata->setDemande(null);
            $demande->setDuplicata(null);
            $this->em->flush();
            $this->em->remove($duplicata);
        }
        if ($ctvo = $demande->getCtvo()) {
            $this->em->remove($ctvo);
        }
        if ($changementAdresse = $demande->getChangementAdresse()) {
            $this->em->remove($changementAdresse);
        }

        if ($commande = $demande->getCommande()) {
            $commande->setDemande(null);
            $this->em->flush();
        }

        $this->em->remove($demande);
        $this->em->flush();
    }

    public function generateCerfa(Demande $demande)
    {
        $folder = $demande->getGeneratedCerfaPath();
        $file = $demande->getGeneratedCerfaPathFile();
        // create directory
        // dump($folder);die;
        if (!is_dir($folder)) mkdir($folder, 0777, true);
        // end create file 
        // get cerfa if not exist
        if (!is_file($file)) { // attente de finalité du process
            if ($demande->getCommande()->getDemarche()->getType() !== "DC"){
                $cerfa = $this->commandeManager->editer($demande->getCommande());
                $cerfa = \base64_decode($cerfa);
            } else {
                $cerfa = file_get_contents('asset/CerfaSession/CerfaSession.pdf');
            }
            
            if ($cerfa == false) {
                return "#";
            }
            
            $filefinal = file_put_contents($file, $cerfa);
        }
        
        return $file;
    }

    public function generateFacture(Demande $demande)
    {
        $folder = $demande->getGeneratedCerfaPath();
        $file = $demande->getGeneratedFacturePathFile();
        // create directory
        if (!is_dir($folder)) mkdir($folder, 0777, true);
        // end create file 
        // get facture if not exist
        if (!is_file($file)) { // attente de finalité du process
            $snappy = new Pdf('/usr/local/bin/wkhtmltopdf');
            $filename = "Facture";
            $html = $this->twig->render("payment/facture.html.twig", array(
                "demande"=> $demande,
            ));
            $output = $snappy->getOutputFromHtml($html);
            
            $filefinal = file_put_contents($file, $output);
        }
        
        return $file;
    }

    public function find($id)
    {

        return $this->repository->find($id);
    }

    public function getUserWithoutSendDocumentInDay(int $day, MailManager $mailManager){
        $relanceLevel = $this->getRelanceLevel($day);
        $responses = $this->repository->getUserWithoutSendDocumentInDay($day, $relanceLevel);
        if ($day === 27)
        {
            $object = "Attention plus que 3 jours pour envoyer les documents !";
        } else {
            $object = (30 - $day).' jours restant pour envoyer les documents';
        }
        
        $template = $this->getTemplateForRelance($day);
        foreach ($responses as $response)
        {
            $mailManager->sendEmail($emails=[$response['email']], $template, "CG Officiel - ".$object, ['responses'=> ['client' => $response]]);
            $client = $this->clientManager->find($response['idClient']);
            $client->setRelanceLevel($relanceLevel);
            $this->clientManager->save($client);
        }
    }
    public function getUserWithSendDocumentButNotValidInDay(int $day, MailManager $mailManager){
        $relanceLevel = $this->getRelanceLevelDocNonValid($day);
        $responses = $this->repository->getUserWithSendDocumentButNotValidInDay($day, $relanceLevel);
        $restDay = 30 - $day;
        if ($day === 27)
        {
            $object = "Attention plus que 3 jours pour réenvoyer les documents valides !";
        } else {
            $object = $restDay.' jours restant pour réenvoyer les documents valides';
        }
        
        $template = $this->getTemplateForRelanceDocNonValid($day);
        foreach ($responses as $response)
        {
            $mailManager->sendEmail($emails=[$response['email']], $template, "CG Officiel - ".$object, ['responses'=> ['client' => $response, 'restDay' => $restDay]]);
            $client = $this->clientManager->find($response['idClient']);
            $client->setRelanceLevel($relanceLevel);
            $this->clientManager->save($client);
        }
    }

    private function getRelanceLevel(int $day)
    {
        switch($day){
            case 7:
                $return = 5;
                break;
            case 14:
                $return = 6;
                break;
            case 20:
                $return = 7;
                break;
            case 27:
                $return = 8;
                break;
            default:
                $return = 4;
                break;
        }

        return $return;
    }
    private function getRelanceLevelDocNonValid(int $day)
    {
        switch($day){
            case 7:
                $return = 9;
                break;
            case 14:
                $return = 10;
                break;
            case 20:
                $return = 11;
                break;
            case 27:
                $return = 12;
                break;
            default:
                $return = 8;
                break;
        }

        return $return;
    }

    private function getTemplateForRelance(int $day)
    {
        $template = 'relance/email2.html.twig';
        if ($day === 27){
            $template = 'relance/email3.html.twig';
        }

        return $template;
    }
    private function getTemplateForRelanceDocNonValid(int $day)
    {
        $template = 'relance/email4.html.twig';

        return $template;
    }

    public function sendUserForRelance($level = 0)
    {
        $users = $this->repository->findUserForRelance($level);
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
}