<?php

namespace App\Repository;

use App\Entity\PreviewEmail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PreviewEmail|null find($id, $lockMode = null, $lockVersion = null)
 * @method PreviewEmail|null findOneBy(array $criteria, array $orderBy = null)
 * @method PreviewEmail[]    findAll()
 * @method PreviewEmail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PreviewEmailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PreviewEmail::class);
    }

    /**
     * @return PreviewEmail[] Returns an array of PreviewEmail objects
     */
    
    public function getPreviewEmailRelanceDemarche()
    {
        return $this->createQueryBuilder('p')
            ->where('p.sendAt <:now')
            ->andWhere('p.status = :pending')
            ->andWhere('p.typeEmail = :typeEmail')
            ->setParameter('typeEmail', PreviewEmail::MAIL_RELANCE_DEMARCHE)
            ->setParameter('pending', PreviewEmail::STATUS_PENDING)
            ->setParameter('now', (new \DateTime())->format('Y-m-d H:i:s'))
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    
    public function getPreviewEmailRelanceAll()
    {
        return $this->createQueryBuilder('p')
            ->where('p.sendAt <:now')
            ->andWhere('p.status = :pending')
            ->andWhere('p.typeEmail < :typeEmail')
            ->setParameter('typeEmail', PreviewEmail::MAIL_RELANCE_DONE)
            ->setParameter('pending', PreviewEmail::STATUS_PENDING)
            ->setParameter('now', (new \DateTime())->format('Y-m-d H:i:s'))
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function getPreviewEmailRelanceForm()
    {
        return $this->createQueryBuilder('p')
            ->where('p.sendAt <:now')
            ->andWhere('p.status = :pending')
            ->andWhere('p.typeEmail = :typeEmail')
            ->setParameter('typeEmail', PreviewEmail::MAIL_RELANCE_FORMULAIRE)
            ->setParameter('pending', PreviewEmail::STATUS_PENDING)
            ->setParameter('now', (new \DateTime())->format('Y-m-d H:i:s'))
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?PreviewEmail
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
