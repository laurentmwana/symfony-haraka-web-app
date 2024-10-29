<?php

namespace App\Mapped;

final class MappedSearch
{
  private ?string $query;

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
