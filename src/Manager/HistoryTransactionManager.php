<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\HistoryTransaction;
use App\Form\Demande\DemandeCtvoType;
use App\Form\Demande\DemandeDivnType;
use App\Form\Demande\DemandeCessionType;
use App\Form\Demande\DemandeDuplicataType;
use App\Form\Demande\DemandeChangementAdresseType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use App\Entity\User;
use App\Entity\Transaction;
use App\Repository\HistoryTransactionRepository;
use App\Repository\TransactionRepository;
use Twig_Environment as Twig;
use App\Utils\StatusTreatment;

class HistoryTransactionManager
{
    private $em;
    private $repository;
    private $statusTreatment;
    private $transactionRepository;
    private $transactionManager;
    public function __construct
    (
        EntityManagerInterface            $em,
        HistoryTransactionRepository      $repository,
        StatusTreatment                   $statusTreatment,
        TransactionRepository             $transactionRepository,
        TransactionManager                $transactionManager
    )
    {
        $this->em                       =  $em;
        $this->repository               =  $repository;
        $this->statusTreatment          =  $statusTreatment;
        $this->transactionRepository    =  $transactionRepository;
        $this->transactionManager       =  $transactionManager;
    }

    public function init()
    {
        return new HistoryTransaction();
    }

    public function save(HistoryTransaction $historyTransaction)
    {
        if (!$historyTransaction instanceof HistoryTransaction)
            return;
        $this->em->persist($historyTransaction);
        $this->em->flush();
    }

    public function saveResponseTransaction($responses)
    {
        $historyTransaction = $this->repository->findOneBy(['transactionId' => $responses["transaction_id"]]);
        if (\is_null($historyTransaction))
            $historyTransaction = $this->init();
        if (!$historyTransaction instanceof HistoryTransaction)
            return;
        $historyTransaction->setTransactionId($responses["transaction_id"])
        ->setData(json_encode($responses))->setStatus($responses["response_code"])
        ->setStatusMessage($this->statusTreatment->getMessageStatus($responses["response_code"]));
        $transaction = $this->transactionRepository->findOneBy(["transactionId" => $responses["transaction_id"]]);
        if ($transaction instanceof Transaction) {
            $historyTransaction->setDemande($transaction->getDemande());            
            $transaction->setStatus($responses["response_code"]);
            if($responses["response_code"] === 00 ){ 
                $facture = $transactionManager->generateNumFacture($transaction);
                $transaction->setFacture($facture);      
            }
            $this->transactionManager->save($transaction);
        }   
        $this->save($historyTransaction);
    }

}