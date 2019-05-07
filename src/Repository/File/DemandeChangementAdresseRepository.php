<?php

namespace App\Repository\File;

use App\Entity\File\DemandeChangementAdresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DemandeChangementAdresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeChangementAdresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeChangementAdresse[]    findAll()
 * @method DemandeChangementAdresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeChangementAdresseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DemandeChangementAdresse::class);
    }

    // /**
    //  * @return DemandeChangementAdresse[] Returns an array of DemandeChangementAdresse objects
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
    public function findOneBySomeField($value): ?DemandeChangementAdresse
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
