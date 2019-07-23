<?php

namespace App\Repository;

use App\Entity\ChangementAdresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ChangementAdresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChangementAdresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChangementAdresse[]    findAll()
 * @method ChangementAdresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChangementAdresseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ChangementAdresse::class);
    }

    // /**
    //  * @return ChangementAdresse[] Returns an array of ChangementAdresse objects
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
    public function findOneBySomeField($value): ?ChangementAdresse
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
