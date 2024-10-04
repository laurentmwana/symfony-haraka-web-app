<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }
    /**
     * @return Query
     */
    public function findSearchQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('s')

            ->leftJoin('s.actualLevel', 'ac')
            ->innerJoin('ac.level', 'l')
            ->innerJoin('l.sector', 'se')
            ->innerJoin('l.programme', 'p')
            ->innerJoin('l.yearAcademic', 'y')
            ->addSelect('se', 'y', 'p', 'l', 'ac');

        if (null !== $query && !empty($query)) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('s.id', ':val'),
                $qb->expr()->like('s.name', ':val'),
                $qb->expr()->like('s.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        return $qb->orderBy('s.updated_at', 'DESC')->getQuery();
    }

    //    public function findOneBySomeField($value): ?Student
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
