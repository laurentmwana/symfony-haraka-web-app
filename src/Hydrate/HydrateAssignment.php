<?php

namespace App\Hydrate;

use App\Entity\Checker;
use App\Entity\Faculty;
use App\Entity\YearAcademic;
use App\Entity\ExpenseControl;

final class HydrateAssignment
{

  private ?ExpenseControl $expenseControl = null;

  public ?YearAcademic $yearAcademic = null;

  private ?string $query = null;



  public function getExpenseControl(): ?ExpenseControl
  {
    return $this->expenseControl;
  }

  public function setExpenseControl(ExpenseControl $expenseControl): static
  {
    $this->expenseControl = $expenseControl;

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

  public function getQuery(): string|null
  {
    return $this->query;
  }


  public function setQuery(?string $query): static
  {
    $this->query = $query;

    return $this;
  }
}
