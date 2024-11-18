<?php

namespace App\Repository;

use App\Entity\Watch;
use App\Entity\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ShowcaseRepository;
use App\Entity\Showcase;

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
            ->leftJoin('wb.member', 'm')
            ->andWhere('m = :member') 
            ->setParameter('member', $member)
            ->getQuery()
            ->getResult();
    }
    
    public function remove(Watch $watch, bool $flush = false): void
    {
        $showcaseRepository = $this->getEntityManager()->getRepository(Showcase::class);

        $showcases = $showcaseRepository->findWatchShowcases($watch);

        // Supprimer l'association avec chaque galerie
        foreach ($showcases as $showcase) {
            $showcase->removeWatch($watch);
            $this->getEntityManager()->persist($showcase);
        }

        $this->getEntityManager()->remove($watch);
        
        if ($flush) {
            $this->getEntityManager()->flush();
        }
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
