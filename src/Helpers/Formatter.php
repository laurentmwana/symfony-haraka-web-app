<?php

namespace App\Helpers;

use App\Entity\Level;
use App\Entity\Checker;
use App\Entity\YearAcademic;
use App\Entity\ExpenseControl;

final class Formatter
{
  public static function yearAcademic(?YearAcademic $yearAcademic): ?string
  {
    return $yearAcademic instanceof YearAcademic
      ? sprintf(
        '%s [%s]',
        $yearAcademic->getName(),
        $yearAcademic->isClosed() ? 'cloturée' : 'actuelle'
      ) : null;
  }

  public static function checker(?Checker $checker): ?string
  {
    return $checker instanceof Checker
      ? sprintf('%s - %s', $checker->getName(), $checker->getFirstname()) : null;
  }

  public static function expenseControl(?ExpenseControl $expenseControl): ?string
  {
    return $expenseControl instanceof ExpenseControl
      ? sprintf(
        '%s - %s',
        $expenseControl->getStartAt()->format('d-m-Y'),
        $expenseControl->getEndAt()->format('d-m-Y')
      ) : null;
  }


  public static function level(?Level $level): ?string
  {
    return $level instanceof Level
      ? sprintf(
        '%s - %s [%s]',
        $level->getProgramme()->getName(),
        $level->getSector()->getAlias(),
        $level->getYearAcademic()->getName(),
      ) : null;
  }

  public static function levelWithStudent(?Level $level): ?string
  {
    return $level instanceof Level
      ? sprintf(
        '%s - %s [%s]',
        $level->getProgramme()->getName(),
        $level->getSector()->getAlias(),
        $level->getYearAcademic()->getName(),
      ) : null;
  }
}
