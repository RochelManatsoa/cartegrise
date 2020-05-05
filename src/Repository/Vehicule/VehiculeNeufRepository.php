<?php

namespace App\Repository\Vehicule;

use App\Entity\Vehicule\VehiculeNeuf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method VehiculeNeuf|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehiculeNeuf|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehiculeNeuf[]    findAll()
 * @method VehiculeNeuf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiculeNeufRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VehiculeNeuf::class);
    }

    // /**
    //  * @return VehiculeNeuf[] Returns an array of VehiculeNeuf objects
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
    public function findOneBySomeField($value): ?VehiculeNeuf
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
