<?php

/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-17 13:14:01 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-05-27 13:32:32
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
use App\Manager\TransactionManager;
use App\Repository\DemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Translation\TranslatorInterface;
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
        TokenStorageInterface  $tokenStorage
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
        // dd($demande);
        $demande->setDateDemande(new \Datetime());
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

    public function getDossiersAFournir(Demande $demande)
    {
        $typeDemande = $demande->getCommande()->getDemarche()->getType();

        if (in_array($typeDemande, TypeDemande::TYPE_CHOICES)) {
            return $this->translator->trans('type_demande.daf.' . strtolower($typeDemande));
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
        // if (!is_file($file)) { // attente de finalité du process
            $cerfa = $this->commandeManager->editer($demande->getCommande(), "Mandat");
            if ($cerfa == false) {
                return "#";
            }
            $decoded = \base64_decode($cerfa);
            $filefinal = file_put_contents($file, $decoded);
        // }
        
        return $file;
    }

    public function find($id)
    {

        return $this->repository->find($id);
    }
}