<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\ExpenseControl;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ExpenseControl>
 */
class ExpenseControlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpenseControl::class);
    }



    public function findSearchQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('e')
            ->innerJoin('e.yearAcademics', 'y')
            ->addSelect('y');

        if (null !== $query && !empty($query)) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('c.id', ':val'),
                $qb->expr()->like('c.start_at', ':val'),
                $qb->expr()->like('c.end_at', ':val'),
                $qb->expr()->like('c.description', ':val'),
                $qb->expr()->like('c.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        return $qb->orderBy('e.created_at', 'DESC')->getQuery();
    }
}
