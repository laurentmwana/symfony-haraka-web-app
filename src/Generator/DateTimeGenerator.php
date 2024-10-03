<?php

namespace App\Generator;

class DateTimeGenerator
{
    public static function getNextAcademicYear(string $name): string
    {
        [$startYear, $endYear] = explode('-', $name);

        $newStartYear = (int)$startYear + 1;
        $newEndYear = (int)$endYear + 1;

        return "{$newStartYear}-{$newEndYear}";
    }
}
