<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\HelpersRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class HelpersExtension extends AbstractExtension
{

    public function getFilters(): array
    {
        return [
            new TwigFilter('isAdmin', [HelpersRuntime::class, 'isAdmin']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('cn', [HelpersRuntime::class, 'cn']),
        ];
    }
}
