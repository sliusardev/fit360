<?php

namespace App\Enums;

enum MembershipsAccessTypeEnum: string
{
    case PUBLIC = 'public';
    case MEMBERS_ONLY = 'members_only';
    case INVITE_ONLY = 'invite_only';
    case PRIVATE = 'private';

    public static function allValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
