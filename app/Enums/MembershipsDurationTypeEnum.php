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
        return [
            self::FIXED->value,
            self::RECURRING->value,
            self::LIFETIME->value,
            self::TRIAL->value,
        ];
    }
}
