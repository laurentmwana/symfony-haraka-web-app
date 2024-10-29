<?php

namespace App\Repository;

use App\Entity\Checker;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Checker>
 */
class CheckerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Checker::class);
    }


    public function findSearchQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('c');

        if (null !== $query && !empty($query)) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('c.id', ':val'),
                $qb->expr()->like('c.name', ':val'),
                $qb->expr()->like('c.firstname', ':val'),
                $qb->expr()->like('c.number_phone', ':val'),
                $qb->expr()->like('c.gender', ':val'),
                $qb->expr()->like('c.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        return $qb->orderBy('c.updated_at', 'DESC')->getQuery();
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.user', 'u')
            ->addSelect('u')
            ->getQuery()
            ->getResult();
    }
}
