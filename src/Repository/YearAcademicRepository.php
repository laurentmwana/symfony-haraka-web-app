<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\YearAcademic;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<YearAcademic>
 */
class YearAcademicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YearAcademic::class);
    }

    public function findSearchQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('y');

        if (null !== $query && !empty($query)) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('y.id', ':val'),
                $qb->expr()->like('y.name', ':val'),
                $qb->expr()->like('y.closed', ':val'),
                $qb->expr()->like('y.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        return $qb
            ->orderBy('y.created_at', 'DESC')
            ->orderBy('y.closed', 'ASC')
            ->getQuery();
    }

    public function findCurrentYear(): YearAcademic
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.closed = :cl')
            ->setParameter('cl', false)
            ->getQuery()
            ->getSingleResult();
    }
}
