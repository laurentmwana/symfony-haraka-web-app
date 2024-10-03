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
    public function __construct(ManagerRegistry $registry)
    {
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
}
