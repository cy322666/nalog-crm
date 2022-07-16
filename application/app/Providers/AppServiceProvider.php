<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::registerNavigationGroups([
            'Shop',
            'Blog',
        ]);

        UserMenuItem::make()
            ->label('Аккаунты')
            ->url('shops')
            ->icon('heroicon-s-cog');

        Filament::registerScripts([
            resource_path('js/app.js'),
        ]);

        Filament::registerStyles([
            resource_path('css/app.css'),
        ]);

        URL::forceScheme('http');//s
    }
}
