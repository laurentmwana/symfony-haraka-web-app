<?php

namespace App\Mapped;

use App\Entity\YearAcademic;

final class MappedYear
{
  private ?string $query = null;

  private ?YearAcademic $yearAcademic = null;


  public function getQuery(): ?string
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
}
