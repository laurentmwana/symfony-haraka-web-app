<?php

namespace App\Helpers;

use App\Entity\Checker;
use App\Entity\ExpenseControl;

final class Formatter
{

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
}
