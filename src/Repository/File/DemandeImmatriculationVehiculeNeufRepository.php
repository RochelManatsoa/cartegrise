<?php

namespace App\Repository\File;

use App\Entity\File\DemandeImmatriculationVehiculeNeuf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method DemandeImmatriculationVehiculeNeuf|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeImmatriculationVehiculeNeuf|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeImmatriculationVehiculeNeuf[]    findAll()
 * @method DemandeImmatriculationVehiculeNeuf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeImmatriculationVehiculeNeufRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DemandeImmatriculationVehiculeNeuf::class);
    }

    // /**
    //  * @return DemandeImmatriculationVehiculeNeuf[] Returns an array of DemandeImmatriculationVehiculeNeuf objects
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
    public function findOneBySomeField($value): ?DemandeImmatriculationVehiculeNeuf
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
