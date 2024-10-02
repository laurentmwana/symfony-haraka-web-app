<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Search
{
  public string $placeholder = "Faire une recherche...";

  public function value(): string
  {
    return "";
  }
}
