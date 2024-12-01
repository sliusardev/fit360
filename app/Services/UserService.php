<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Models\User;

class UserService
{
    public static function getUsersTrainerList()
    {
        return User::query()
            ->role(RoleEnum::TRAINER->value)
            ->get()
            ->pluck('full_name', 'id')
            ->toArray();
    }

    public static function getClientCount(): int
    {
        return User::query()
            ->role(RoleEnum::CLIENT->value)
            ->count();
    }

    public static function getTrainerCount(): int
    {
        return User::query()
            ->role(RoleEnum::TRAINER->value)
            ->count();
    }
}
