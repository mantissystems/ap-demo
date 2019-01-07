<?php

namespace App\Repository;

use App\Entity\Actionpost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Actionpost|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actionpost|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actionpost[]    findAll()
 * @method Actionpost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionpostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Actionpost::class);
        
    }
    public function Actionpost(int $page = 1, Tag $tag = null): Pagerfanta
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('a', 't')
            ->innerJoin('p.author', 'a')
            ->leftJoin('p.tags', 't')
            ->where('p.publishedAt <= :now')
            ->orderBy('p.publishedAt', 'DESC')
            ->setParameter('now', new \DateTime());

        if (null !== $tag) {
            $qb->andWhere(':tag MEMBER OF p.tags')
                ->setParameter('tag', $tag);
        }

        return $this->createPaginator($qb->getQuery(), $page);
    }
    // /**
    //  * @return Actionpost[] Returns an array of Actionpost objects
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
    public function findOneBySomeField($value): ?Actionpost
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
