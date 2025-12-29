<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class MemberPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('member')
            ->path('member')
            ->authGuard('web')
            ->login(\App\Filament\Member\Pages\Auth\Login::class)
            ->registration(\App\Filament\Member\Pages\Auth\Register::class)
            ->passwordReset()
            ->profile(\App\Filament\Member\Pages\Auth\EditProfile::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(
                in: app_path('Filament/Member/Resources'),
                for: 'App\\Filament\\Member\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Member/Pages'),
                for: 'App\\Filament\\Member\\Pages'
            )
            ->discoverWidgets(
                in: app_path('Filament/Member/Widgets'),
                for: 'App\\Filament\\Member\\Widgets'
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
