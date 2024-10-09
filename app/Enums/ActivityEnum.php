<?php

namespace App\Enums;

enum ActivityEnum: string
{
    case GROUP = 'group';
    case INDIVIDUAL = 'individual';

    /**
     * @return array
     */
    public static function allValues(): array
    {
        return [
            self::GROUP->value,
            self::INDIVIDUAL->value,
        ];
    }

}
