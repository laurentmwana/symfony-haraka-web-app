<?php

namespace App\Repository;

use App\Entity\Amount;
use App\Entity\Installment;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Installment>
 */
class InstallmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Installment::class);
    }

    public function calculateTotalAmount(Amount $amount): float|int
    {
        return $this->getTotalPriceForAmount($amount);
    }

    public function totalPriceWithoutItemId(Amount $amount, Installment $installment): float|int
    {
        return $this->getTotalPriceForAmount($amount, $installment->getId());
    }

    /**
     * @param \App\Entity\Amount $amount
     * @return Installment[]
     */
    public function findItemToAmount(Amount $amount): array
    {
        return $this->createQueryBuilder('i')
            ->select('SUM(i.price) as totalPrice', 'COUNT(i.id) as totalItems')
            ->andWhere('i.amount = :amount')
            ->setParameter('amount', $amount->getId())
            ->getQuery()
            ->getResult();
    }

    /**
     * Méthode commune pour calculer le prix total des items, avec ou sans exclusion d'un item spécifique.
     */
    private function getTotalPriceForAmount(Amount $amount, ?int $excludeItemId = null): float
    {
        $qb = $this->createQueryBuilder(alias: 'i')
            ->select('SUM(i.price)')
            ->andWhere('i.amount = :amount')
            ->setParameter('amount', $amount->getId());

        if ($excludeItemId !== null) {
            $qb->andWhere('i.id != :id')
                ->setParameter('id', $excludeItemId);
        }

        return (float) $qb->getQuery()->getSingleScalarResult();
    }
}
