<?php

namespace App\Repository\Vehicule;

use App\Entity\Vehicule\CaracteristiqueTechVehiculeNeuf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CaracteristiqueTechVehiculeNeuf|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaracteristiqueTechVehiculeNeuf|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaracteristiqueTechVehiculeNeuf[]    findAll()
 * @method CaracteristiqueTechVehiculeNeuf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaracteristiqueTechVehiculeNeufRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CaracteristiqueTechVehiculeNeuf::class);
    }

    // /**
    //  * @return CaracteristiqueTechVehiculeNeuf[] Returns an array of CaracteristiqueTechVehiculeNeuf objects
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
    public function findOneBySomeField($value): ?CaracteristiqueTechVehiculeNeuf
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
