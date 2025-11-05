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
        return [
            self::PUBLIC->value,
            self::MEMBERS_ONLY->value,
            self::INVITE_ONLY->value,
            self::PRIVATE->value,
        ];
    }
}
