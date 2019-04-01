<?php

namespace App\Repository;

use App\Entity\Cession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cession|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cession|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cession[]    findAll()
 * @method Cession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CessionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cession::class);
    }

    // /**
    //  * @return Cession[] Returns an array of Cession objects
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

    /*
    public function findOneBySomeField($value): ?Cession
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
