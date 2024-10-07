<?php

namespace App\Repository;

use App\Entity\Paid;
use App\Entity\Student;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Paid>
 */
class PaidRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paid::class);
    }


    public function findAllPaids(Student $student): Query
    {
        $qb = $this->createQueryBuilder('p')
            ->innerJoin('p.student', 's')
            ->innerJoin('p.level', 'l')
            ->innerJoin('l.programme', 'pr')
            ->innerJoin('l.sector', 'se')
            ->leftJoin('s.payments', 'pa')
            ->leftJoin('l.yearAcademic', 'y')
            ->leftJoin('pa.amount', 'a')
            ->leftJoin('pa.installment', 'i')
            ->addSelect('s', 'l', 'i', 'a', 'pr', 'se', 'y', 'pa');

        $qb->where('s.id = :studentId')->setParameter('studentId', $student);

        return $qb
            ->orderBy('pr.name', 'DESC')
            ->orderBy('pr.id', 'ASC')->getQuery();
    }
}
