<?php

namespace App\Enums;

enum MembershipsAccessTypeEnum: string
{
    case GYM = 'gym';
    case GROUP = 'group';
    case ALL = 'all';

    /**
     * @return array
     */
    public static function allValues(): array
    {
        return [
            self::GYM->value,
            self::GROUP->value,
            self::ALL->value,
        ];
    }

    public static function allValuesTranslated(): array
    {
        return [
            self::GYM->value => trans('dashboard.'.self::GYM->value),
            self::GROUP->value => trans('dashboard.'.self::GROUP->value),
            self::ALL->value => trans('dashboard.'.self::ALL->value),
        ];
    }
}
