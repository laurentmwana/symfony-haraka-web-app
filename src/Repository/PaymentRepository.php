<?php

namespace App\Repository;

use App\Entity\Paid;
use App\Entity\Level;
use App\Entity\Amount;
use App\Entity\Payment;
use App\Entity\Student;
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

    /**
     * @param \App\Entity\Amount $amount
     * @param \App\Entity\Student $student
     * @param \App\Entity\Level $level
     * @return Payment[]
     */
    public function findAllForStudent(
        Amount $amount,
        Student $student,
        Level $level
    ): array {
        $qb = $this->createQueryBuilder('p')
            ->innerJoin('p.student', 's')
            ->innerJoin('p.level', 'l')
            ->innerJoin('p.amount', 'a')
            ->innerJoin('a.installments', 'ci')
            ->innerJoin('p.installment', 'i')
            ->addSelect('s', 'l', 'ci', 'i', 'a');

        $qb
            ->andWhere('s.id = :student')
            ->andWhere('a.id = :amount')
            ->andWhere('l.id = :level');

        $qb
            ->setParameter('student', $student)
            ->setParameter('level', $level)
            ->setParameter('amount', $amount);

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
