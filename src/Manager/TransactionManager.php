<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
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
use App\Repository\TransactionRepository;
use Twig_Environment as Twig;

class TransactionManager
{
    private $em;
    private $formFactory;
    private $twig;
    private $repository;
    public function __construct
    (
        EntityManagerInterface $em,
        TransactionRepository      $repository
    )
    {
        $this->em =          $em;
        $this->repository =  $repository;
    }

    public function init()
    {
        return new Transaction();
    }

    public function save(Transaction $transaction)
    {
        if (!$transaction instanceof Transaction)
            return;
        $this->em->persist($transaction);
        $this->em->flush();
    }

    public function generateIdTransaction(Transaction $transaction)
    {
        $tempsId = $transaction->getId();
        while (strlen($tempsId) < 6)
            $tempsId = '0'.$tempsId;

        return $tempsId;
    }

    public function findByTransactionId($transactionId)
    {
        dd($transactionId);
        $transaction = $this->repository->findOneBy(['transactionId' => $transactionId]);
        if (!$transaction instanceof Transaction) {
            return null;
        }

        return $transaction;
    }

    public function generateNumFacture()
    {
        $numFacture = $this->repository->numFacture();
        $facture = $numFacture[0][1];

        return $facture + 1;
    }
}