<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class HelpersRuntime implements RuntimeExtensionInterface
{
    public function __construct() {}

    public function cn(string $className, string ...$classNames): string
    {
        return implode(' ', array_merge([$className], $classNames));
    }
}
