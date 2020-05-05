<?php

namespace App\Repository\Vehicule;

use App\Entity\Vehicule\CarrosierVehiculeNeuf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method CarrosierVehiculeNeuf|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarrosierVehiculeNeuf|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarrosierVehiculeNeuf[]    findAll()
 * @method CarrosierVehiculeNeuf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarrosierVehiculeNeufRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CarrosierVehiculeNeuf::class);
    }

    // /**
    //  * @return CarrosierVehiculeNeuf[] Returns an array of CarrosierVehiculeNeuf objects
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
    public function findOneBySomeField($value): ?CarrosierVehiculeNeuf
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
