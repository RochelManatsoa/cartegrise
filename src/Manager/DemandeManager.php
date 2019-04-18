<?php

/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-17 13:14:01 
 * @Last Modified by:   Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Last Modified time: 2019-04-17 13:14:01 
 */
namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Demande;
use App\Entity\Commande;
use App\Entity\Transaction;
use App\Form\Demande\DemandeCtvoType;
use App\Form\Demande\DemandeDivnType;
use App\Form\Demande\DemandeCessionType;
use App\Form\Demande\DemandeDuplicataType;
use App\Form\Demande\DemandeChangementAdresseType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use App\Entity\User;
use App\Manager\TransactionManager;
use App\Repository\DemandeRepository;
use Twig_Environment as Twig;

class DemandeManager
{
    private $em;
    private $formFactory;
    private $twig;
    private $repository;
    private $transactionManager;
    public function __construct
    (
        EntityManagerInterface $em,
        FormFactoryInterface   $formFactory,
        Twig                   $twig,
        DemandeRepository      $repository,
        TransactionManager     $transactionManager
    )
    {
        $this->em                 = $em;
        $this->formFactory        = $formFactory;
        $this->twig               = $twig;
        $this->repository         = $repository;
        $this->transactionManager = $transactionManager;
    }

    private function init()
    {
        return new Demande();
    }

    public function generateForm(Commande $commande)
    {
        $demande = $this->init();
        $commande->addDemande($demande);
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

}