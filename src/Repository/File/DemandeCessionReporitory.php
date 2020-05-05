<?php

namespace App\Repository\File;

use App\Entity\File\DemandeCession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method DemandeCession|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeCession|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeCession[]    findAll()
 * @method DemandeCession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeCessionReporitory extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DemandeCession::class);
    }

    // /**
    //  * @return DemandeCession[] Returns an array of DemandeCession objects
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
    public function findOneBySomeField($value): ?DemandeCession
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
