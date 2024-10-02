<?php

namespace App\Repository;

use App\Entity\Faculty;
use Doctrine\ORM\Query;
use App\Entity\Department;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Department>
 */
class DepartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Department::class);
    }

    public function findSearchQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('d')
            ->innerJoin('d.faculty', 'f')
            ->addSelect('f');

        if (null !== $query && !empty($query)) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('d.id', ':val'),
                $qb->expr()->like('d.name', ':val'),
                $qb->expr()->like('d.alias', ':val'),
                $qb->expr()->like('d.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        return $qb->orderBy('d.updated_at', 'DESC')->getQuery();
    }


    //    public function findOneBySomeField($value): ?Department
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
