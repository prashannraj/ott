<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandLogo(asset('icons/web-app-manifest-192x192.png'))
            ->brandLogoHeight('60px')
            ->renderHook(
                        PanelsRenderHook::SIDEBAR_NAV_START,
                        fn () => new HtmlString('
                            <div class="px-4 pb-4 text-center leading-tight border-b border-gray-200">
                                <div class="text-xs font-semibold tracking-wide text-gray-700">
                                    चलचित्र तथा लोकसञ्चार
                                </div>
                                <div class="text-[11px] text-gray-500">
                                    प्रवर्द्धन बोर्ड
                                </div>
                            </div>
                        ')
                    )
            ->renderHook(
                        PanelsRenderHook::FOOTER,
                        fn () => new HtmlString('
                            <div class="w-full text-center py-2 text-[12px] text-gray-500 border-t border-gray-200">
                                Developed by: <span class="font-semibold text-gray-600">Appan Technology Pvt Ltd</span>
                            </div>
                        ')
                    )
            ->favicon(asset('icons/web-app-manifest-192x192.png'))
            ->colors([
                'primary' => Color::rgb('88, 132, 226'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                //\App\Filament\Widgets\AdminStats::class,
                \App\Filament\Widgets\MonthlyGrowthChart::class,
                \App\Filament\Widgets\MostWatchedVideos::class,
                \App\Filament\Widgets\LatestUsers::class,
                \App\Filament\Widgets\SubscriptionRevenue::class,
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
