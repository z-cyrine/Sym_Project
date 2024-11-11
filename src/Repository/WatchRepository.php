<?php

namespace App\Repository;

use App\Entity\Watch;
use App\Entity\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @extends ServiceEntityRepository<Watch>
 */
class WatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Watch::class);
    }
    
    /**
     * @return Watch[] Returns an array of Watch objects for a member
     */
    public function findMemberWatches(Member $member): array
    {
        return $this->createQueryBuilder('w')
            ->leftJoin('w.watchBox', 'wb')
            ->andWhere('wb.owner = :member')
            ->setParameter('member', $member)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Watch[] Returns an array of Watch objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Watch
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
