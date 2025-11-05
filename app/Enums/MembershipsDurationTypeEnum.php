<?php

namespace App\Enums;

enum MembershipsDurationTypeEnum: string
{
    case FIXED = 'fixed';
    case RECURRING = 'recurring';
    case LIFETIME = 'lifetime';
    case TRIAL = 'trial';

    public static function allValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
