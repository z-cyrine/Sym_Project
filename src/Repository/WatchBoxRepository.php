<?php

namespace App\Repository;

use App\Entity\WatchBox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\WatchRepository;
use App\Entity\Watch;

/**
 * @extends ServiceEntityRepository<WatchBox>
 */
class WatchBoxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WatchBox::class);
    }
    
    public function remove(WatchBox $entity, bool $flush = false): void
    {
        $watchRepository = $this->getEntityManager()->getRepository(Watch::class);

        // clean the watches properly
        $watches = $entity->getWatches();
        foreach($watches as $watch) {
                $watchRepository->remove($watch, $flush);
        }
        $this->getEntityManager()->remove($entity);

        if ($flush) {
                $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return WatchBox[] Returns an array of WatchBox objects
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

    //    public function findOneBySomeField($value): ?WatchBox
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
