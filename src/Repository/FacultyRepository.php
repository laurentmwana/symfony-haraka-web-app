<?php

namespace App\Repository;

use App\Entity\Faculty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Faculty>
 */
class FacultyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Faculty::class);
    }

    /**
     * @return Query
     */
    public function findSearchQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('f');

        if (null !== $query && !empty($query)) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('f.id', ':val'),
                $qb->expr()->like('f.name', ':val'),
                $qb->expr()->like('f.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        return $qb->orderBy('f.updated_at', 'DESC')->getQuery();
    }
}
