<?php

namespace App\Repository;

use App\Entity\Paid;
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

    public function findAllPaid(Paid $paid): array
    {
        $qb = $this->createQueryBuilder('p')
            ->innerJoin('p.student', 's')
            ->innerJoin('p.level', 'l')
            ->innerJoin('p.amount', 'a')
            ->innerJoin('a.installments', 'ci')
            ->innerJoin('p.installment', 'i')
            ->addSelect('s', 'l', 'ci', 'i', 'a');

        $qb->where('p.student = :student')
            ->andWhere('p.level = :level');
        $qb->setParameter('student', $paid->getStudent())
            ->setParameter('level', $paid->getLevel());

        return $qb->orderBy('p.payment_at', 'DESC')
            ->getQuery()->getResult();
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

        return $qb->orderBy('p.payment_at', 'DESC')->getQuery();
    }
}
