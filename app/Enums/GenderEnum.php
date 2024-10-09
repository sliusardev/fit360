<?php

namespace App\Enums;

enum GenderEnum: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    /**
     * @return array
     */
    public static function allValues(): array
    {
        return [
            self::MALE->value,
            self::FEMALE->value,
        ];
    }

    public static function allValuesTranslated(): array
    {
        return [
            self::MALE->value => trans('dashboard.'.self::MALE->value ),
            self::FEMALE->value => trans('dashboard.'.self::FEMALE->value ),
        ];
    }
}
