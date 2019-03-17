<?php

namespace App\Repository;

use App\Entity\AdresseNewTitulaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AdresseNewTitulaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdresseNewTitulaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdresseNewTitulaire[]    findAll()
 * @method AdresseNewTitulaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdresseNewTitulaireRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AdresseNewTitulaire::class);
    }

    // /**
    //  * @return AdresseNewTitulaire[] Returns an array of AdresseNewTitulaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdresseNewTitulaire
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
