<?php

namespace App\Subscriber;

use App\Entity\Amount;
use Doctrine\ORM\Events;
use App\Entity\YearAcademic;
use App\Exception\YearIsClosedException;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;

final class YearClosedSubscriber
{
  public function prePersist(PrePersistEventArgs $args): void
  {
    $model = $args->getObject();

    if ($model instanceof Amount) {
      self::throwException($model->getYearAcademic());
    }
  }

  public function preUpdate(PreUpdateEventArgs $args): void
  {
    $model = $args->getObject();

    if ($model instanceof Amount) {
      self::throwException($model->getYearAcademic());
    }
  }

  public function preRemove(PreRemoveEventArgs $args): void
  {
    $model = $args->getObject();

    if ($model instanceof Amount) {
      self::throwException($model->getYearAcademic());
    }
  }

  /**
   * @return array<int, string>
   */
  public function getSubscribedEvents(): array
  {
    return [
      Events::prePersist,
      Events::preUpdate,
      Events::preRemove,
    ];
  }

  private static function throwException(YearAcademic $year): void
  {
    if ($year->isClosed()) {
      throw new YearIsClosedException($year->getName());
    }
  }
}
