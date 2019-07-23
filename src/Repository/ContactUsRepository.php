<?php

namespace App\Repository;

use App\Entity\ContactUs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContactUs|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactUs|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactUs[]    findAll()
 * @method ContactUs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactUsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContactUs::class);
    }

    // /**
    //  * @return ContactUs[] Returns an array of ContactUs objects
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
    public function findOneBySomeField($value): ?ContactUs
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
