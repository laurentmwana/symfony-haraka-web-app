<?php

namespace App\Hydrate;

use App\Entity\Amount;
use App\Entity\Installment;
use Doctrine\Common\Collections\Collection;

final class HydratePaid
{
  /**
   * @var Collection<int, Installment>
   */
  private Collection $installments;


  /**
   * @return Collection<int, Installment>
   */
  public function getInstallments(): Collection
  {
    return $this->installments;
  }
}
