<?php

namespace App\Repository\File;

use App\Entity\File\DemandeDuplicata;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method DemandeDuplicata|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeDuplicata|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeDuplicata[]    findAll()
 * @method DemandeDuplicata[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeDuplicataType extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DemandeDuplicata::class);
    }

    // /**
    //  * @return DemandeDuplicata[] Returns an array of DemandeDuplicata objects
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
    public function findOneBySomeField($value): ?DemandeDuplicata
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
