<?php

namespace App\Repository;

use App\Entity\Showcase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Showcase>
 */
class ShowcaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Showcase::class);
    }
    
    /**
     * @return [Galerie][] Returns an array of [Galerie] objects
     */
     public function findWatchShowcases(Watch $watch): array
    {
        dd($watch); 
        return $this->createQueryBuilder('s')
            ->leftJoin('s.watches', 'w')
            ->andWhere('w = :watch')
            ->setParameter('watch', $watch)
            ->getQuery()
            ->getResult()
        ;
    }

    //    /**
    //     * @return Showcase[] Returns an array of Showcase objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Showcase
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
