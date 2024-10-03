<?php

namespace App\Enum;

enum PaidEnum: string
{
    case TOTALITY = 'paid the full amount';

    case PAID_NO_TOTALITY = 'is paid no totality';

    case NO_PAID  = "has not yet paid";
}
