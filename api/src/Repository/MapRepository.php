<?php

namespace App\Repository;

use App\Entity\Map;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Map>
 *
 * @method Map|null find($id, $lockMode = null, $lockVersion = null)
 * @method Map|null findOneBy(array $criteria, array $orderBy = null)
 * @method Map[]    findAll()
 * @method Map[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MapRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Map::class);
    }

    //    /**
    //     * @return Song[] Returns an array of Song objects
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

    //    public function findOneBySomeField($value): ?Song
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
