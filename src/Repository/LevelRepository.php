<?php

namespace App\Repository;

use App\Entity\Level;
use App\Entity\Sector;
use Doctrine\ORM\Query;
use App\Entity\Programme;
use App\Entity\YearAcademic;
use App\Hydrate\HydrateLevel;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Level>
 */
class LevelRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private YearAcademicRepository $yearAcademicRepository

    ) {
        parent::__construct($registry, Level::class);
    }

    public function findSearchQuery(HydrateLevel $hydrateLevel): Query
    {
        $qb = $this->createQueryBuilder('l')
            ->leftJoin('l.students', 's')
            ->innerJoin('l.programme', 'p')
            ->innerJoin('l.yearAcademic', 'y')
            ->innerJoin('l.sector', 'se')
            ->addSelect('s', 'se', 'y', 'p');

        if ($hydrateLevel->getProgramme() instanceof Programme) {
            $qb->andWhere('l.programme = :programme')
                ->setParameter('programme', $hydrateLevel->getProgramme());
        }

        if ($hydrateLevel->getSector() instanceof Sector) {
            $qb->andWhere('l.sector = :sector')
                ->setParameter('sector', $hydrateLevel->getSector());
        }

        if ($hydrateLevel->getYearAcademic() instanceof YearAcademic) {
            $qb->andWhere('l.yearAcademic = :yearAcademic')
                ->setParameter('yearAcademic', $hydrateLevel->getYearAcademic());
        }

        return $qb->orderBy('l.created_at', 'DESC')->getQuery();
    }


    /**
     * @return Level[]
     */
    public function findAllWithAllRelation(int $studentId): array
    {
        $qb = $this->createQueryBuilder('l')
            ->leftJoin('l.students', 's')
            ->innerJoin('l.programme', 'p')
            ->innerJoin('l.yearAcademic', 'y')
            ->innerJoin('l.sector', 'se')
            ->addSelect('s', 'se', 'y', 'p');


        $qb->andWhere('s.id = :studentId')
            ->setParameter('studentId', $studentId);

        return $qb->orderBy('l.created_at', 'DESC')
            ->getQuery()->getResult();
    }


    public function findSearchWithStudentQuery(HydrateLevel $hydrateLevel): Query
    {
        $qb = $this->createQueryBuilder('l')
            ->leftJoin('l.students', 's')
            ->innerJoin('l.programme', 'p')
            ->innerJoin('l.yearAcademic', 'y')
            ->innerJoin('l.sector', 'se')
            ->innerJoin('l.students', 'sts')
            ->addSelect('s', 'se', 'y', 'p', 'sts');

        if ($hydrateLevel->getProgramme() instanceof Programme) {
            $qb->andWhere('l.programme = :programme')
                ->setParameter('programme', $hydrateLevel->getProgramme());
        }

        if ($hydrateLevel->getSector() instanceof Sector) {
            $qb->andWhere('l.sector = :sector')
                ->setParameter('sector', $hydrateLevel->getSector());
        }

        if ($hydrateLevel->getYearAcademic() instanceof YearAcademic) {
            $qb->andWhere('l.yearAcademic = :yearAcademic')
                ->setParameter('yearAcademic', $hydrateLevel->getYearAcademic());
        }

        if ($hydrateLevel->getQuery() !== null && !empty($hydrateLevel->getQuery())) {
            $query = $hydrateLevel->getQuery();

            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('sts.id', ':q'),
                $qb->expr()->like('sts.name', ':q'),
                $qb->expr()->like('sts.firstname', ':q'),
                $qb->expr()->like('sts.lastname', ':q'),
                $qb->expr()->like('sts.gender', ':q'),
                $qb->expr()->like('sts.number_phone', ':q'),
                $qb->expr()->like('sts.happy', ':q'),
                $qb->expr()->like('sts.created_at', ':q')
            ))
                ->setParameter('q', "%$query%");
        }

        return $qb->orderBy('l.created_at', 'DESC')->getQuery();
    }

    /**
     * @return Level[]
     */
    public function findAllWith(): array
    {
        $year = $this->yearAcademicRepository->findCurrentYear();

        $qb = $this->createQueryBuilder('l')
            ->innerJoin('l.programme', 'p')
            ->innerJoin('l.yearAcademic', 'y')
            ->innerJoin('l.sector', 's')
            ->addSelect('s', 'y', 'p');

        $qb->andWhere('l.yearAcademic = :yearAcademic')
            ->setParameter('yearAcademic', $year);

        return $qb->orderBy('l.created_at', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
