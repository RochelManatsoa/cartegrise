<?php

namespace App\Repository;

use App\Entity\Cotitulaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cotitulaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cotitulaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cotitulaires[]    findAll()
 * @method Cotitulaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CotitulairesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cotitulaires::class);
    }

    // /**
    //  * @return Cotitulaires[] Returns an array of Cotitulaires objects
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
    public function findOneBySomeField($value): ?Cotitulaires
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
