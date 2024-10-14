<?php

namespace App\Providers\Filament;

use App\Filament\Panel\Pages\Auth\Login;
use App\Filament\Panel\Pages\Auth\Register;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PanelPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('panel')
            ->path('panel')
            ->login(Login::class)
            ->registration(Register::class)
//            ->brandLogo(asset('assets/images/header/logo.jpg'))
//            ->brandLogoHeight('80px')
            ->brandName('Fit360')
            ->profile()
            ->colors([
                'primary' => Color::Gray,
            ])
            ->maxContentWidth('full')
            ->sidebarCollapsibleOnDesktop()
            ->discoverResources(in: app_path('Filament/Panel/Resources'), for: 'App\\Filament\\Panel\\Resources')
            ->discoverPages(in: app_path('Filament/Panel/Pages'), for: 'App\\Filament\\Panel\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Panel/Widgets'), for: 'App\\Filament\\Panel\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
//                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
