<?php

namespace App\Repository;

use App\Entity\NotificationEmail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method NotificationEmail|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotificationEmail|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotificationEmail[]    findAll()
 * @method NotificationEmail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationEmailRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NotificationEmail::class);
    }

    // /**
    //  * @return NotificationEmail[] Returns an array of NotificationEmail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NotificationEmail
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
