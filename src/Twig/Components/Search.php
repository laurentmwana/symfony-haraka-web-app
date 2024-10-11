<?php

namespace App\Twig\Components;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Search
{
  public function __construct(
    private RequestStack $request
  ) {}

  public string $placeholder = "Faire une recherche...";

  public function value(): string
  {
    return $this->request->getCurrentRequest()->query->get('query');
  }
}
