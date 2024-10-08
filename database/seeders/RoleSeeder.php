<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = RoleEnum::allValues();

        $roles = Role::query()->pluck('name')->toArray();

        foreach ($values as $value){

            if(in_array($value, $roles)) continue;

            Role::create([
                'name' => $value,
                'guard_name' => 'web',
            ]);
        }
    }
}
