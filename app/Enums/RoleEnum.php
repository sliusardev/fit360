<?php

namespace App\Enums;

enum RoleEnum: string
{
    case USER = 'user';
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case CLIENT = 'client';

    /**
     * @return array
     */
    public static function allValues(): array
    {
        return [
            self::USER->value,
            self::ADMIN->value,
            self::MANAGER->value,
            self::CLIENT->value,
        ];
    }

    /**
     * @return array
     */
    public static function dashboardAllowedRoles(): array
    {
        return [
            self::ADMIN->value,
            self::MANAGER->value,
        ];
    }

    /**
     * @return array
     */
    public static function usersPermissions(): array
    {
        return [
            self::ADMIN->value,
            self::MANAGER->value,
        ];
    }
}
