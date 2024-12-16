<?php

namespace App\Enum;

enum PaidEnum: string
{
    case TOTALITY = 'TOTALITY';

    case PAID_NO_TOTALITY = 'PAID_NO_TOTALITY';

    case NO_PAID  = "NO_PAID";
}
