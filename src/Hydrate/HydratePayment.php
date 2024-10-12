<?php

namespace App\Hydrate;

use App\Entity\Level;
use App\Entity\Checker;
use App\Entity\Faculty;
use App\Entity\YearAcademic;
use App\Entity\ExpenseControl;

final class HydratePayment
{
  private ?YearAcademic $yearAcademic = null;
  private ?Level $level = null;
  private ?string $query = null;

  public function getQuery(): string|null
  {
    return $this->query;
  }

  public function setQuery(?string $query): static
  {
    $this->query = $query;

    return $this;
  }

  public function getYearAcademic(): ?YearAcademic
  {
    return $this->yearAcademic;
  }

  public function setYearAcademic(?YearAcademic $yearAcademic): static
  {
    $this->yearAcademic = $yearAcademic;

    return $this;
  }

  public function getLevel(): ?Level
  {
    return $this->level;
  }


  public function setLevel(?Level $level): static
  {
    $this->level = $level;

    return $this;
  }
}
