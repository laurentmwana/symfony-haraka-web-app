<?php

namespace App\Repository;

use App\Entity\Amount;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Amount>
 */
class AmountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Amount::class);
    }
    public function findSearchQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.installments', 'i')
            ->innerJoin('a.programme', 'p')
            ->innerJoin('a.yearAcademic', 'y')
            ->addSelect('i', 'p', 'y');

        if (null !== $query && !empty($query)) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('a.id', ':val'),
                $qb->expr()->like('a.price', ':val'),
                $qb->expr()->like('a.max_number_installment', ':val'),
                $qb->expr()->like('a.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        return $qb->orderBy('a.updated_at', 'DESC')->getQuery();
    }

    //    public function findOneBySomeField($value): ?Amount
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
