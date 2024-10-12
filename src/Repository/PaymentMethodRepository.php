<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\PaymentMethod;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<PaymentMethod>
 */
class PaymentMethodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentMethod::class);
    }

    public function findSearchQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('p');

        if (null !== $query && !empty($query)) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('p.id', ':val'),
                $qb->expr()->like('p.name', ':val'),
                $qb->expr()->like('p.number_account', ':val'),
                $qb->expr()->like('p.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        return $qb->orderBy('p.updated_at', 'DESC')->getQuery();
    }
}
