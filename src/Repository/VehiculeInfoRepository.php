<?php

namespace App\Repository;

use App\Entity\VehiculeInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VehiculeInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehiculeInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehiculeInfo[]    findAll()
 * @method VehiculeInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiculeInfoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VehiculeInfo::class);
    }

    // /**
    //  * @return VehiculeInfo[] Returns an array of VehiculeInfo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VehiculeInfo
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
