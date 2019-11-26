<?php

namespace App\Repository;

use App\Entity\EmailHistory;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EmailHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailHistory[]    findAll()
 * @method EmailHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailHistory::class);
    }

    // /**
    //  * @return EmailHistory[] Returns an array of EmailHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EmailHistory
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findEmailHistoryByUser(User $user)
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.user', 'u')
            ->andWhere('u.id = :idUser')
            ->orderBy('e.createdAt', 'desc')
            ->setParameter('idUser', $user->getId())
            ->getQuery()
        ;
    }
}
