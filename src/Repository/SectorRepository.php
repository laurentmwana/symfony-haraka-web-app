<?php

namespace App\Repository;

use App\Entity\Sector;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Sector>
 */
class SectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sector::class);
    }

    public function findSearchQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('s')
            ->innerJoin('s.department', 'd')
            ->addSelect('d');

        if (null !== $query && !empty($query)) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('s.id', ':val'),
                $qb->expr()->like('s.name', ':val'),
                $qb->expr()->like('s.alias', ':val'),
                $qb->expr()->like('s.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        return $qb->orderBy('s.updated_at', 'DESC')->getQuery();
    }

    //    public function findOneBySomeField($value): ?Sector
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
