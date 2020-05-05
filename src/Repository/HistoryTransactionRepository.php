<?php

namespace App\Repository;

use App\Entity\HistoryTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method HistoryTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryTransaction[]    findAll()
 * @method HistoryTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryTransactionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HistoryTransaction::class);
    }

    // /**
    //  * @return HistoryTransaction[] Returns an array of HistoryTransaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HistoryTransaction
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
