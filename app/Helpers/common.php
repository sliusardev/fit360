<?php

use App\Services\SettingService;
use App\Services\ThemeService;
use Illuminate\Support\Carbon;

function themeView(string $bladeName, array $params = [])
{
    return ThemeService::themeView($bladeName, $params);
}

function themeSettings(): array
{
    return ThemeService::themeSettings(SettingService::value('theme'));
}

function dateTimeLocaleFormat(Carbon $dateTime): string
{
    return $dateTime->locale(app()->getLocale())->isoFormat("D MMMM Y HH:mm, dddd");
}
