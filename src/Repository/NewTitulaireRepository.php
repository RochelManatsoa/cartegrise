<?php

namespace App\Repository;

use App\Entity\NewTitulaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NewTitulaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewTitulaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewTitulaire[]    findAll()
 * @method NewTitulaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewTitulaireRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NewTitulaire::class);
    }

    // /**
    //  * @return NewTitulaire[] Returns an array of NewTitulaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewTitulaire
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
