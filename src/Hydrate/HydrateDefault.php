<?php

namespace App\Hydrate;

class HydrateDefault
{
  private string|int|null $id = null;

  private ?string $name = null;

  public function getId(): string|int|null
  {
    return $this->id;
  }

  public function setId(string|int|null $id): static
  {
    $this->id = $id;

    return $this;
  }
  public function getName(): ?string
  {
    return $this->name;
  }
  public function setName(?string $name): static
  {
    $this->name = $name;

    return $this;
  }
}
