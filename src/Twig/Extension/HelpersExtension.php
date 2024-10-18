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
            new TwigFilter('isStudent', [HelpersRuntime::class, 'isStudent']),
            new TwigFilter('isChecker', [HelpersRuntime::class, 'isChecker']),
            new TwigFilter('isTotality', [HelpersRuntime::class, 'isTotality']),
            new TwigFilter('isPaidNoTotality', [HelpersRuntime::class, 'isPaidNoTotality']),
            new TwigFilter('isNoPaid', [HelpersRuntime::class, 'isNoPaid']),
            new TwigFilter('calculateTotality', [HelpersRuntime::class, 'calculateTotality']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('cn', [HelpersRuntime::class, 'cn']),
            new TwigFunction('statePaid', [HelpersRuntime::class, 'statePaid']),
            new TwigFunction('remainingTotality', [HelpersRuntime::class, 'remainingTotality']),

        ];
    }
}
