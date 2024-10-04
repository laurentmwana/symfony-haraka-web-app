<?php

namespace App\Repository;

use App\Entity\Checker;
use App\Entity\Faculty;
use Doctrine\ORM\Query;
use App\Entity\Assignment;
use App\Entity\YearAcademic;
use App\Entity\ExpenseControl;
use App\Hydrate\HydrateAssignment;
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


    public function findSearchQuery(HydrateAssignment $hydrateAssignment): Query
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.expenseControl', 'e')
            ->innerJoin('e.yearAcademics', 'y')
            ->leftJoin('a.faculty', 'f')
            ->innerJoin('a.checkers', 'c')
            ->addSelect('e', 'f', 'c', 'y');


        if ($hydrateAssignment->getExpenseControl() instanceof ExpenseControl) {
            $qb->andWhere('a.expenseControl = :expenseControl')
                ->setParameter('expenseControl', $hydrateAssignment->getExpenseControl());
        }

        if ($hydrateAssignment->getYearAcademic() instanceof YearAcademic) {
            $qb->andWhere('y.id = :yearAcademic')
                ->setParameter(
                    'yearAcademic',
                    $hydrateAssignment->getYearAcademic()->getId()
                );
        }

        if ($hydrateAssignment->getQuery() !== null && !empty($hydrateAssignment->getQuery())) {
            $query = $hydrateAssignment->getQuery();

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
