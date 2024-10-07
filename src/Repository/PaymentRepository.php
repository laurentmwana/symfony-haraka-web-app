<?php

namespace App\Repository;

use App\Entity\Payment;
use Doctrine\ORM\Query;
use App\Hydrate\HydratePayment;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Payment>
 */
class PaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
    }

    public function findSearchQuery(HydratePayment $hydrate): Query
    {
        $qb = $this->createQueryBuilder('p')
            ->innerJoin('p.student', 's')
            ->innerJoin('p.level', 'l')
            ->innerJoin('p.amount', 'a')
            ->innerJoin('a.installments', 'ci')
            ->innerJoin('p.installment', 'i')
            ->addSelect('s', 'l', 'ci', 'i', 'a');

        // if ($hydrateLevel->getSector() instanceof Sector) {
        //     $qb->andWhere('l.sector = :sector')
        //         ->setParameter('sector', $hydrateLevel->getSector());
        // }

        // if ($hydrateLevel->getYearAcademic() instanceof YearAcademic) {
        //     $qb->andWhere('l.yearAcademic = :yearAcademic')
        //         ->setParameter('yearAcademic', $hydrateLevel->getYearAcademic());
        // }


        return $qb->orderBy('p.payment_at', 'DESC')->getQuery();
    }
}
