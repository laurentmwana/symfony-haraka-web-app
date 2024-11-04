<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\GetDataRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class GetDataExtension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('year', [GetDataRuntime::class, 'getCurrentYear']),
        ];
    }
}
