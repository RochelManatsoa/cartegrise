<?php

namespace App\Repository\File;

use App\Entity\File\DemandeIvn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DemandeIvn|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeIvn|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeIvn[]    findAll()
 * @method DemandeIvn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeIvnRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DemandeIvn::class);
    }

    // /**
    //  * @return DemandeIvn[] Returns an array of DemandeIvn objects
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
    public function findOneBySomeField($value): ?DemandeIvn
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
