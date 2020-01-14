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
use App\Entity\{User, Commande};
use App\Repository\{TransactionRepository, HistoryTransactionRepository};
use Twig_Environment as Twig;

class TransactionManager
{
    private $em;
    private $formFactory;
    private $twig;
    private $repository;
    private $historyTransactionManager;
    public function __construct
    (
        EntityManagerInterface $em,
        TransactionRepository      $repository,
        HistoryTransactionRepository $historyTransactionRepository
    )
    {
        $this->em =          $em;
        $this->repository =  $repository;
        $this->historyTransactionRepository =  $historyTransactionRepository;
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
        $transaction = $this->repository->findOneByTransactionId($transactionId);
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

    public function generateDateCreateForTransaction()
    {
        $transactions = $this->repository->findByCreateAt(null);
        foreach($transactions as $transaction){
            if ($transaction->getTransactionId()){
                $historyTransaction = $this->historyTransactionRepository->findOneByTransactionId($transaction->getTransactionId());
                if ($historyTransaction !== null){
                    $data = json_decode($historyTransaction->getData());
                    $dateString = $data->transmission_date; 
                    $string = '-'; 
                    $position = '4';
                    $dateString = substr_replace($dateString, $string, $position, 0 );
                    $position = '7';
                    $dateString = substr_replace($dateString, $string, $position, 0 );
                    $string = ' ';
                    $position = '10';
                    $dateString = substr_replace($dateString, $string, $position, 0 );
                    $string = ':';
                    $position = '13';
                    $dateString = substr_replace($dateString, $string, $position, 0 );
                    $position = '16';
                    $dateString = substr_replace($dateString, $string, $position, 0 );
                    $dateCreate = new \DateTime($dateString);
                    $transaction->setCreateAt($dateCreate);
                    $this->save($transaction);
                }
            }
        }
    }

    public function findTransactionSuccessByCommand(Commande $commande)
    {
        return $this->repository->findOneBy(['commande' => $commande->getId(), 'status' => '00']);
    }
}