<?php

namespace App\Helpers;

use App\Entity\Installment;

final class Statistic
{


  /**
   * @param array<int, Installment> $installments
   * @return float|int
   */
  public static function totality(array $installments): float|int
  {
    return array_sum(array_map(
      fn(Installment $installment) => $installment->getPrice(),
      $installments
    ));
  }

  /**
   * @param float|int $amount
   * @param array<int, Installment> $installments
   * @return float|int
   */
  public static function remaining(float|int $amount, array $installments): float|int
  {
    $totality = self::totality($installments);

    return $amount - $totality;
  }
}
