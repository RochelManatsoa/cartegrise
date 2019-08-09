<?php

namespace App\Repository\Vehicule;

use App\Entity\Vehicule\Carrossier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Carrossier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carrossier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carrossier[]    findAll()
 * @method Carrossier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarrosierRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Carrossier::class);
    }

    // /**
    //  * @return Carrossier[] Returns an array of Carrossier objects
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
    public function findOneBySomeField($value): ?Carrossier
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
