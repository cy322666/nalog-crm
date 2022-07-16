<?php

namespace App\Providers;

use App\Filament\Pages\Profile;
use App\Filament\Pages\Shops;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CrmServiceProvider extends ServiceProvider
{
    protected array $pages = [
//        Shops::class,
    ];

    public function boot()
    {
        //TODO crash
//        $this->app->bind('events', 'App\Services\Event\EventService');

        //TODO боковое меню
        //TODO add settings
//        Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
//            return $builder->group('Settings', [
//                // An array of `NavigationItem` objects.
//            ]);
//        });

        Filament::registerScripts([
            asset('js/websocket.js'),
        ]);


        //user manu
        Filament::serving(function () {
            //TODO add in <head>
//            Filament::pushMeta([
//                new HtmlString('<link rel="manifest" href="/site.webmanifest" />'),
//            ]);


            //notification component
            Filament::registerRenderHook(
                'global-search.end',
                fn (): string => Blade::render('@livewire(\'notification\')')
            );

            Filament::registerUserMenuItems([

                UserMenuItem::make()
                    ->label('Аккаунты')
                    ->url('shops/list')
                    ->icon('heroicon-s-cog'),

                //Profile::class
            ]);

            //custom colors
            Filament::registerTheme(env('APP_URL').'/css/app.css');

//            Filament::registerScripts([
//                asset('js/my-script.js'),
//            ]);
//
//            Filament::registerStyles([
//                'https://unpkg.com/tippy.js@6/dist/tippy.css',
//                asset('css/my-styles.css'),
//            ]);
        });
    }
}
