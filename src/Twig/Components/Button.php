<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Button
{

  /**
   * @var array<string, array<string, string>>
   */
  public array $variants = [
    "variant" => [
      "default" => "bg-primary text-primary-foreground shadow hover:bg-primary/90",
      "destructive" => "bg-destructive text-destructive-foreground shadow-sm hover:bg-destructive/90",
      "outline" => "border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground",
      "secondary" => "bg-gray-700 text-secondary-foreground shadow-sm hover:bg-secondary/80",
      "ghost" =>  "hover:bg-accent hover:text-accent-foreground",
      "link" =>  "text-gray-50 dark:text-gray-600 underline-offset-4 hover:underline",
    ],

    "size" => [
      "default" => "h-9 px-4 py-2",
      "sm" => "h-8 rounded-md px-3 text-xs",
      "lg" => "h-10 rounded-md px-8",
      "icon" => "h-9 w-9",
    ]
  ];
  public string $variant = "default";
  public string $size = "sm";
}
