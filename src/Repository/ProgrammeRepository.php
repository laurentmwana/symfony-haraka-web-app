<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Programme;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Programme>
 */
class ProgrammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Programme::class);
    }

    public function findSearchQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('p');

        if (null !== $query && !empty($query)) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('p.id', ':val'),
                $qb->expr()->like('p.name', ':val'),
                $qb->expr()->like('p.alias', ':val'),
                $qb->expr()->like('p.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        return $qb
            ->orderBy('p.created_at', 'DESC')
            ->getQuery();
    }
}
