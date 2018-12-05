<?php

namespace App\Repository;

use App\Entity\Cartegrise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cartegrise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cartegrise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cartegrise[]    findAll()
 * @method Cartegrise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartegriseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cartegrise::class);
    }

    // /**
    //  * @return Cartegrise[] Returns an array of Cartegrise objects
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
    public function findOneBySomeField($value): ?Cartegrise
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
