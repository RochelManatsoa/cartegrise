<?php

namespace App\Repository;

use App\Entity\{Commande, Transaction, User};
use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Manager\Crm\Modele\CrmSearch;
use App\Entity\Systempay\Transaction as SystempayTransaction;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    // /**
    //  * @return Commande[] Returns an array of Commande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneBySomeField($value): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.commande = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function findByCommandeByClient(Client $client)
    {
        return $this->createQueryBuilder('c')
            ->join('c.client', 'client')
            ->andWhere('client = :val')
            ->setParameter('val', $client)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function getQueryCommandPayedForUser(User $user)
    {
        return $this->createQueryBuilder('c')
            ->join('c.client', 'client')
            ->join('client.user', 'user')
            ->join('c.systempayTransaction', 'transaction')
            ->where('user.id = :user')
            ->andWhere('transaction.status = :success')
            ->andWhere('c.demande is null')
            ->setParameter('user', $user->getId())
            ->setParameter('success', SystempayTransaction::TRANSACTION_SUCCESS)
            ->getQuery()
        ;
    }
    
    public function getLastCommandePayed(User $user)
    {
        return $this->createQueryBuilder('c')
            ->join('c.client', 'client')
            ->join('client.user', 'user')
            ->join('c.systempayTransaction', 'transaction')
            ->where('user.id = :user')
            ->andWhere('transaction.status = :success')
            ->andWhere('c.demande is null')
            ->setParameter('user', $user->getId())
            ->setParameter('success', SystempayTransaction::TRANSACTION_SUCCESS)
            ->setMaxResults(1)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function queryAllCommandeByClient(Client $client)
    {
        return $this->createQueryBuilder('c')
            ->join('c.client', 'client')
            ->andWhere('client = :val')
            ->orderBy('c.ceerLe', 'DESC')
            ->setParameter('val', $client)
            ->getQuery()
        ;
    }

    public function getDailyCommandeFacture($begin, \DateTime $now)
    {
        $qb = $this->createQueryBuilder('c')
        ->join('c.facture','fact')
        // ->join('c.client','cli')
        // ->join('cli.user','u')
        ->distinct()
        // ->where('trans.status =:paramSuccess')
        ->where('fact.createdAt <= :now');
        // ->andWhere('trans.amount IS NOT NULL')
        // ->andWhere('trans.createAt <= :now');

        $qb
        // ->setParameter('paramSuccess', Transaction::STATUS_SUCCESS)
        ->setParameter('now', $now);
        // dd($qb->getQuery()->getResult());

        return $qb->getQuery()->getResult();
    }
    public function getDailyCommandeFactureLimitate(\DateTime $start, \DateTime $end)
    {
        // $now->modify('- 40day');
        $qb = $this->createQueryBuilder('c')
        // ->select('u.email, c.clientNom, c.clientPrenom, c.id as idClient, c.clientGenre')
        ->join('c.facture','fact')
        // ->join('c.client','cli')
        // ->join('cli.user','u')
        ->distinct()
        // ->where('trans.status =:paramSuccess')
        // ->andWhere('trans.amount IS NOT NULL')
        // ->andWhere('trans.createAt <= :end')
        ->where('fact.createdAt <= :end')
        ->andWhere('fact.createdAt > :start');

        $qb
        // ->setParameter('paramSuccess', Transaction::STATUS_SUCCESS)
        ->setParameter('start', $start)
        ->setParameter('end', $end);
        // dd($qb->getQuery()->getResult());

        return $qb->getQuery()->getResult();
    }

    public function getCrmFilter(CrmSearch $crmSearch)
    {
        if (!$crmSearch->isFilterable())
            return [];
        /**
         * search started
         */
        $builder = $this->createQueryBuilder('c')
        ->leftJoin('c.facture', 'facture')
        ->leftJoin('c.demande', 'demande')
        ->leftJoin('demande.transaction', 'transaction')
        ->where('facture IS NOT NULL or (demande IS NOT NULL and transaction IS NOT NULL and transaction.status = :successTransactionStatus)')
        ->setParameter('successTransactionStatus', '00');
        #filter email
        if (null != $crmSearch->getEmail()) {
            $builder
            ->join('c.client', 'client')
            ->join('client.user', 'user')
            ->andWhere('user.email like :email')
            ->setParameter('email', '%'.$crmSearch->getEmail().'%');
        }
        #filter nom
        if (null != $crmSearch->getNom()) {
            if (null == $crmSearch->getEmail()) {
                $builder
                ->join('c.client', 'client');
            }
            $builder
            ->andWhere('client.clientNom like :nom OR client.clientPrenom like :nom')
            ->setParameter('nom', '%'.$crmSearch->getNom().'%');
        }
        #filter immatriculation
        if (null != $crmSearch->getImmatriculation()) {
            $builder
            ->andWhere('c.immatriculation like :immatriculation')
            ->setParameter('immatriculation', '%'.$crmSearch->getImmatriculation().'%');
        }

        return $builder->getQuery()->getResult();        
    }

    public function getCommandesPaidedWithoutDemande($level = 0)
    {
        $date = $this->relanceDateAfterSuccess($level);
        return $this->createQueryBuilder('c')
            ->leftJoin('c.client','cl')
            ->leftJoin('cl.user','u')
            ->leftJoin('c.transaction','t')
            ->leftJoin('c.demande','d')
            ->where('t.status = :success')
            ->andWhere('d IS NULL')
            ->andWhere('u IS NOT NULL')
            ->andWhere('t.createAt = :date')
            ->andWhere('cl.relanceLevel =:level')
            ->setParameter('success', Transaction::STATUS_SUCCESS)
            ->setParameter('level', $level)
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
        ;
    }

    private function relanceDateAfterSuccess($level)
    {
        $date = new \DateTime();
        switch($level){
            case 0:
                $date->modify('-1hour');
                break;
            case 1:
                $date->modify('-1day');
                break;
            default:
                break;
        }

        return $date;
    }

    public function getUserHaveComandNoPayed()
    {
        // get all user with command estimated and not process to payment
        return $this->createQueryBuilder('c')
            ->select('u.id')
            ->leftJoin('c.client','cl')
            ->leftJoin('cl.user','u')
            ->leftJoin('c.systempayTransaction','t')
            ->andWhere('u.id IS NOT NULL and u.remindProcess IS NULL')
            ->distinct()
            ->orderBy('u.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getUserHaveComandFailedPayed()
    {
        //get all user with command with transaction but fail
        return $this->createQueryBuilder('c')
            ->select('u.id userID, c.id commandeId')
            ->leftJoin('c.client','cl')
            ->leftJoin('cl.user','u')
            ->leftJoin('c.systempayTransaction','t')
            ->where('u.id IS NOT NULL')
            ->andWhere('t.id IS NOT NULL')
            ->andWhere('c.remindFailedTransaction < :two OR c.remindFailedTransaction IS NULL')
            ->andWhere('t.status IS NULL OR t.status != :success')
            ->distinct()
            ->orderBy('u.id', 'DESC')
            ->setParameter('success', SystempayTransaction::TRANSACTION_SUCCESS)
            ->setParameter('two', 2)
            ->getQuery()
            ->getResult()
        ;
    }
    
}
