<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Enums\ThemeMode;
use App\Models\AppearanceSetting;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Schema;
use App\Http\Middleware\AdminMiddleware;
use Filament\Http\Middleware\Authenticate;
use Filament\Support\Facades\FilamentView;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use App\Filament\Resources\MasterFixResource\Widgets\LatestMasterFixes;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // Inisialisasi $setting dulu supaya selalu terdefinisi
        $setting = null;

        if (Schema::hasTable('appearance_settings')) {
            $setting = AppearanceSetting::first();
        }

        // Render hook untuk body.start pakai view dan passing $setting
        FilamentView::registerRenderHook(
            'panels::body.start',
            fn() => view('components.dynamic-admin-style', ['setting' => $setting])
        );

        // Render hook untuk head.start, cek dulu $setting dan icon_path
        FilamentView::registerRenderHook(
            'panels::head.start',
            fn() => ($setting && $setting->icon_path)
                ? '<link rel="icon" href="' . asset('storage/' . $setting->icon_path) . '">'
                : ''
        );

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->spa()
            ->darkMode(true)
            ->defaultThemeMode(ThemeMode::System)
            ->databaseNotifications()
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                LatestMasterFixes::class
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
                AdminMiddleware::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make());
    }
}
