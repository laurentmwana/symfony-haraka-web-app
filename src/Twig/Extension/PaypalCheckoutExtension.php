<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\PaypalCheckoutRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class PaypalCheckoutExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('uiPaypal', [PaypalCheckoutRuntime::class, 'uiPaypal'], [
                'is_safe' => ['html']
            ]),
        ];
    }
}
