<?php

namespace App\Repository;

use App\Entity\Duplicata;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Duplicata|null find($id, $lockMode = null, $lockVersion = null)
 * @method Duplicata|null findOneBy(array $criteria, array $orderBy = null)
 * @method Duplicata[]    findAll()
 * @method Duplicata[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DuplicataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Duplicata::class);
    }

    // /**
    //  * @return Duplicata[] Returns an array of Duplicata objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Duplicata
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
