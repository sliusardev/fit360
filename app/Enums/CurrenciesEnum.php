<?php

namespace App\Enums;

enum CurrenciesEnum: string
{
    case UAH = 'UAH';
    case USD = 'USD';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
