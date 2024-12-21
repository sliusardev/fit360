<?php

namespace App\Providers;

use App\Services\CustomFieldService;
use App\Services\SettingService;
use App\Services\ThemeService;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        CustomFieldService::setCustomFields('seo_fields', [
            TextInput::make('seo_title')
                ->columnSpan('full'),

            TextInput::make('seo_text_keys')
                ->columnSpan('full'),

            Textarea::make('seo_description')
                ->columnSpan('full'),
        ]);

        try {
            View::share('settings', SettingService::values());
            ThemeService::getThemeFunctions(SettingService::value('theme'));
            View::share('themeSettings', themeSettings());
        } catch (\Throwable $th) {

        }
//
    }
}
