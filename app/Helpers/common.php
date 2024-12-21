<?php

use App\Services\SettingService;
use App\Services\ThemeService;

function themeView(string $bladeName, array $params = [])
{
    return ThemeService::themeView($bladeName, $params);
}

function themeSettings(): array
{
    return ThemeService::themeSettings(SettingService::value('theme'));
}
