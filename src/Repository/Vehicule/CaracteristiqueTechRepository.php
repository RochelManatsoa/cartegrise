<?php

namespace App\Repository\Vehicule;

use App\Entity\Vehicule\CaracteristiqueTech;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CaracteristiqueTech|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaracteristiqueTech|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaracteristiqueTech[]    findAll()
 * @method CaracteristiqueTech[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaracteristiqueTechRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CaracteristiqueTech::class);
    }

    // /**
    //  * @return CaracteristiqueTech[] Returns an array of CaracteristiqueTech objects
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
    public function findOneBySomeField($value): ?CaracteristiqueTech
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
