<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
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
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Closure;
use Illuminate\Http\Request;


class AdminOnlyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->isAdmin()) {
            auth()->logout();
            session()->flash('admin_only_error', 'Access denied. Only privileged administrators can access this dashboard.');

    return redirect()->route('filament.admin.auth.login');
}
        return $next($request);
    }
}

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->renderHook(
                 'panels::body.end',
                fn (): string => '<script src="' . asset('js/timeout-handler.js') . '"></script>',
                'panels::auth.login.form.before',
                fn () => session('admin_only_error')
                    ? "
                    <div class='mb-4 p-4 rounded-xl border border-red-600 bg-red-600/10 text-red-700 flex items-start gap-3 shadow-sm'>
                        <span class='text-red-600 text-l'>⚠️</span>
                        <div>
                            <div class='font-extrabold text-red-700 text-base uppercase tracking-wide'>
                                Access Restricted !
                            </div>
                            <p class='text-sm leading-tight font-medium'>
                                Only <span class='font-bold'>authorized administrators</span> are allowed to access.
                            </p>
                        </div>
                    </div>
                    "
                    : ''
            )

            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->plugin(
                \Hasnayeen\Themes\ThemesPlugin::make()
            )
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
                AdminOnlyMiddleware::class,
            ])
            ->authGuard('web')
            ->loginRouteSlug('login')
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}