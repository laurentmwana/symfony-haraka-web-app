<?php

namespace App\Repository;

use App\Entity\Quiz;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Quiz>
 */
class QuizRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    /**
     * @return Query
     */
    public function findSearchQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('q');

        if (null !== $query && !empty($query)) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('q.id', ':val'),
                $qb->expr()->like('q.request', ':val'),
                $qb->expr()->like('q.response', ':val'),
                $qb->expr()->like('q.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        return $qb->orderBy('q.created_at', 'DESC')->getQuery();
    }
}
