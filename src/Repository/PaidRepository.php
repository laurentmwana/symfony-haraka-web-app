<?php

namespace App\Repository;

use App\Entity\Paid;
use App\Entity\Student;
use Doctrine\ORM\Query;
use App\Mapped\MappedYear;
use App\Entity\YearAcademic;
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

    public function findSearchQuery(?MappedYear $mapped = null): Query
    {
        $qb = $this->createQueryBuilder('p')
            ->innerJoin('p.student', 's')
            ->innerJoin('s.user', 'u')
            ->innerJoin('s.level', 'l')
            ->innerJoin('l.yearAcademic', 'y')
            ->innerJoin('l.sector', 'se')
            ->addSelect('se', 'y', 'l', 's', 'u');

        if (
            $mapped instanceof MappedYear
            && $mapped->getYearAcademic() instanceof YearAcademic
        ) {
            $qb->andWhere('l.yearAcademic = :yearAcademic')
                ->setParameter('yearAcademic', $mapped->getYearAcademic());
        }

        if (
            $mapped instanceof MappedYear &&
            ($mapped->getQuery() !== null && !empty($mapped->getQuery()))
        ) {
            $qb
                ->andWhere('se.name = :np')
                ->orWhere('s.name = :ns')
                ->setParameter('np', $mapped->getQuery())
                ->setParameter('ns', $mapped->getQuery());
        }

        return $qb->orderBy('p.created_at', 'DESC')->getQuery();
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


    public function findResponseQrcode(string $token): ?Paid
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

        return $qb
            ->where('p.token = :token')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
