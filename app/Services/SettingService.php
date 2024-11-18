<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;

class SettingService
{
    public static function connect()
    {
        try {

            $settings = Setting::query()->first();

            if (!$settings) {
                $settings = static::createNew();
            }

        } catch (\Throwable $th) {
            return null;
        }

        return $settings;
    }

    public static function values(): mixed
    {
        $settings =  static::connect();

        return $settings->data ?? [];
    }

    public static function value(string $value)
    {
        return static::values()[$value] ?? '';
    }

    public static function createNew(): Setting
    {
        return Setting::query()->create([
            'data' => []
        ]);
    }
}
