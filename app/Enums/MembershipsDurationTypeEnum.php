<?php

namespace App\Enums;

enum MembershipsDurationTypeEnum: string
{
    case UNLIMITED = 'unlimited';
    case VISITS = 'visits';

    /**
     * @return array
     */
    public static function allValues(): array
    {
        return [
            self::UNLIMITED->value,
            self::VISITS->value,
        ];
    }

    public static function allValuesTranslated(): array
    {
        return [
            self::UNLIMITED->value => trans('dashboard.'.self::UNLIMITED->value),
            self::VISITS->value => trans('dashboard.'.self::VISITS->value),
        ];
    }
}
