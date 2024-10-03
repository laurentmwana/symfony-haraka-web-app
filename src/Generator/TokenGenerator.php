<?php

namespace App\Generator;

abstract class TokenGenerator
{
    public static function alpha(int $lenght = 4): string
    {
        $alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

        return substr(str_shuffle(str_repeat($alphabet, 60)), 0, $lenght);
    }
}
