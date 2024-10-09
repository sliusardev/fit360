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
}
