<?php

namespace App\Repository;

use App\Entity\Checker;
use App\Entity\Faculty;
use Doctrine\ORM\Query;
use App\Entity\Assignment;
use App\Entity\YearAcademic;
use App\Entity\ExpenseControl;
use App\Hydrate\HydrateAssignment;
use App\Mapped\MappedYear;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Assignment>
 */
class AssignmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assignment::class);
    }

    public function findSearchQueryForChecker(
        Checker $checker,
        ?MappedYear $mapped = null
    ): Query {

        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.expenseControl', 'e')
            ->innerJoin('e.yearAcademics', 'y')
            ->leftJoin('a.faculty', 'f')
            ->innerJoin('a.checkers', 'c')
            ->addSelect('e', 'f', 'c', 'y');

        $qb
            ->where('c.id = :checker')
            ->setParameter('checker', $checker);

        if (
            $mapped instanceof MappedYear &&
            $mapped->getYearAcademic() instanceof YearAcademic
        ) {
            $qb->andWhere('y.id = :yearAcademic')
                ->setParameter(
                    'yearAcademic',
                    $mapped->getYearAcademic()->getId()
                );
        }

        if (
            $mapped instanceof MappedYear &&
            ($mapped->getQuery() !== null && !empty($mapped->getQuery()))
        ) {
            $query = $mapped->getQuery();

            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('y.id', ':q'),
                $qb->expr()->like('y.name', ':q'),
                $qb->expr()->like('y.closed', ':q'),
                $qb->expr()->like('f.id', ':q'),
                $qb->expr()->like('f.name', ':q'),
                $qb->expr()->like('y.created_at', ':q'),
            ))
                ->setParameter('q', "%$query%");
        }


        return $qb->orderBy('a.updated_at', 'DESC')->getQuery();
    }

    public function findSearchQuery(?MappedYear $mapped = null): Query
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.expenseControl', 'e')
            ->innerJoin('e.yearAcademics', 'y')
            ->leftJoin('a.faculty', 'f')
            ->innerJoin('a.checkers', 'c')
            ->addSelect('e', 'f', 'c', 'y');

        if (
            $mapped instanceof MappedYear &&
            $mapped->getYearAcademic() instanceof YearAcademic
        ) {
            $qb->andWhere('y.id = :yearAcademic')
                ->setParameter(
                    'yearAcademic',
                    $mapped->getYearAcademic()->getId()
                );
        }

        if (
            $mapped instanceof MappedYear &&
            $mapped->getQuery() !== null && !empty($mapped->getQuery())
        ) {
            $query = $mapped->getQuery();

            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('y.id', ':q'),
                $qb->expr()->like('y.name', ':q'),
                $qb->expr()->like('y.closed', ':q'),
                $qb->expr()->like('c.name', ':q'),
                $qb->expr()->like('f.id', ':q'),
                $qb->expr()->like('f.name', ':q'),
                $qb->expr()->like('c.firstname', ':q'),
                $qb->expr()->like('c.gender', ':q'),
                $qb->expr()->like('c.number_phone', ':q'),
                $qb->expr()->like('y.created_at', ':q'),
                $qb->expr()->like('c.created_at', ':q')
            ))
                ->setParameter('q', "%$query%");
        }

        return $qb->orderBy('a.updated_at', 'DESC')->getQuery();
    }
}
