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
            ])
            ->brandName('Diwali Chit Funds')
            ->homeUrl('/')
            ->renderHook(
                'panels::user-menu.before',
                fn (): string => \Illuminate\Support\Facades\Blade::render('
                    <a href="/" class="flex items-center justify-center p-2 mr-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition text-gray-500 dark:text-gray-400" title="Visit Website">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </a>
                ')
            );
    }
}
