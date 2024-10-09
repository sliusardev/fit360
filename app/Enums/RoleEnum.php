<?php

namespace App\Enums;

enum RoleEnum: string
{
    case USER = 'user';
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case TRAINER = 'trainer';
    case CLIENT = 'client';

    /**
     * @return array
     */
    public static function allValues(): array
    {
        return [
            self::CLIENT->value,
            self::TRAINER->value,
            self::MANAGER->value,
            self::USER->value,
            self::ADMIN->value,
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
