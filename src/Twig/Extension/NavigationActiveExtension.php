<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\NavigationActiveRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class NavigationActiveExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('isActiveNavlink', [NavigationActiveRuntime::class, 'isActiveNavlink']),
        ];
    }
}
