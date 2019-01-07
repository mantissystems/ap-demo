<?php

namespace App\Repository;

use App\Entity\Actiontag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Actiontag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actiontag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actiontag[]    findAll()
 * @method Actiontag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActiontagRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Actiontag::class);
    }

    // /**
    //  * @return Actiontag[] Returns an array of Actiontag objects
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
    public function findOneBySomeField($value): ?Actiontag
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
