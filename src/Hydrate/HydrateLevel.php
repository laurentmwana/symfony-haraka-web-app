<?php

namespace App\Hydrate;

use App\Entity\Sector;
use App\Entity\Programme;
use App\Entity\YearAcademic;

class HydrateLevel
{
  private ?YearAcademic $yearAcademic = null;

  private ?Programme $programme = null;

  private ?Sector $sector = null;

  private ?string $query = null;


  public function getYearAcademic(): ?YearAcademic
  {
    return $this->yearAcademic;
  }


  public function setYearAcademic(?YearAcademic $yearAcademic): static
  {
    $this->yearAcademic = $yearAcademic;

    return $this;
  }

  public function getProgramme(): ?Programme
  {
    return $this->programme;
  }


  public function setProgramme(?Programme $programme): static
  {
    $this->programme = $programme;

    return $this;
  }

  public function getSector(): ?Sector
  {
    return $this->sector;
  }


  public function setSector(?Sector $sector): static
  {
    $this->sector = $sector;

    return $this;
  }

  public function getQuery(): ?string
  {
    return $this->query;
  }

  public function setQuery(?string $query): static
  {
    $this->query = $query;

    return $this;
  }
}
