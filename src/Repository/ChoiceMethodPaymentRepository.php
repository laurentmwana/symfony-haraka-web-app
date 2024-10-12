<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\ChoiceMethodPayment;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ChoiceMethodPayment>
 */
class ChoiceMethodPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChoiceMethodPayment::class);
    }
    public function findSearchQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('c')
            ->innerJoin('c.yearAcademic', 'y')
            ->leftJoin('c.faculties', 'cf')
            ->addSelect('y', 'cf');

        if (null !== $query && !empty($query)) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('c.id', ':val'),
                $qb->expr()->like('y.name', ':val'),
                $qb->expr()->like('cf.name', ':val'),
                $qb->expr()->like('c.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        return $qb->orderBy('c.updated_at', 'DESC')->getQuery();
    }
}
