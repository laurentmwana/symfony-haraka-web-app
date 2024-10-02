<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Badge
{
  /**
   * @var array<string, string>
   */
  public array $types = [
    "default" => "border-transparent bg-primary text-primary-foreground shadow hover:bg-primary/80",
    "secondary" => "border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80",
    "destructive" => "border-transparent bg-red-400 text-destructive-foreground shadow hover:bg-destructive/80",
    "outline" =>  "text-foreground"
  ];

  public string $type = "default";
}
