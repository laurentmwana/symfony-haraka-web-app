<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\Query;
use App\Entity\Notification;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Notification>
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }


    public function findSearchQuery(User $user, ?string $query): Query
    {
        $qb = $this->createQueryBuilder('n');

        $qb->where('n.user = :userId')
            ->setParameter('userId', $user->getId());

        if (null !== $query && !empty($query)) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('n.title', ':val'),
                $qb->expr()->like('n.description', ':val'),
                $qb->expr()->like('n.eye', ':val'),
                $qb->expr()->like('n.eye_at', ':val'),
                $qb->expr()->like('n.created_at', ':val')
            ))->setParameter(':val', "%$query%");
        }





        return $qb->orderBy('n.created_at', 'DESC')->getQuery();
    }
}
