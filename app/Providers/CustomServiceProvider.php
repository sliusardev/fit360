<?php

namespace App\Providers;

use App\Services\CustomFieldService;
use App\Services\SettingService;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrapFive();

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
        } catch (\Throwable $th) {

        }
//
    }
}
