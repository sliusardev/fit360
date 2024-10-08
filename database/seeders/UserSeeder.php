<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->where('email', 'admin@admin.com')->first();

        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
            ]);
        }

        $role = Role::query()->where('name', RoleEnum::ADMIN->value)->first();

        $user->assignRole($role);
    }
}
