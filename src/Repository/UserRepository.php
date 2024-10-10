<?php

namespace App\Repository;

use App\Entity\User;
use App\Enum\RoleEnum;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }



    public function findSearchQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('u');

        if (null !== $query && !empty($query)) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('u.id', ':val'),
                $qb->expr()->like('u.username', ':val'),
                $qb->expr()->like('u.email', ':val'),
                $qb->expr()->like('u.roles', ':val'),
                $qb->expr()->like('u.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        $qb->where($qb->expr()->orX(
            $qb->expr()->like('u.roles', ':student'),
            $qb->expr()->like('u.roles', ':checker'),
        ));

        $qb->setParameter('student', '%' . RoleEnum::ROLE_STUDENT->value  . '%');
        $qb->setParameter('checker', '%' . RoleEnum::ROLE_CHECKER->value  . '%');

        return $qb->orderBy('u.created_at', 'DESC')->getQuery();
    }


    public function findSearchForStudentQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('u');

        if (null !== $query && !empty($query)) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('u.id', ':val'),
                $qb->expr()->like('u.username', ':val'),
                $qb->expr()->like('u.email', ':val'),
                $qb->expr()->like('u.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        $qb->andWhere($qb->expr()->orX(
            $qb->expr()->like('u.roles', ':student'),
        ));

        $qb->setParameter('student', '%' . RoleEnum::ROLE_STUDENT->value  . '%');

        return $qb->orderBy('u.created_at', 'DESC')->getQuery();
    }


    public function findSearchForCheckerQuery(?string $query): Query
    {
        $qb = $this->createQueryBuilder('u');

        if (null !== $query && !empty($query)) {
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('u.id', ':val'),
                $qb->expr()->like('u.username', ':val'),
                $qb->expr()->like('u.email', ':val'),
                $qb->expr()->like('u.roles', ':val'),
                $qb->expr()->like('u.created_at', ':val')
            ))
                ->setParameter('val', "%$query%");
        }

        $qb->where($qb->expr()->orX(
            $qb->expr()->like('u.roles', ':checker'),
        ));

        $qb->setParameter('checker', '%' . RoleEnum::ROLE_CHECKER->value  . '%');

        return $qb->orderBy('u.created_at', 'DESC')->getQuery();
    }
}
