<?php

namespace App\Providers;

use App\Filament\Navigations\Sidebar\NavigationMap;
use App\Filament\Resources\Shop\ImportResource;
use App\Filament\Resources\Shop\ShopResource;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\UserMenuItem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;
use JeffGreco13\FilamentBreezy\Pages\MyProfile;

class CrmServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //sidebar
        Filament::serving(function () {

            Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {

                foreach (NavigationMap::sidebar() as $groupName => $items) {

                    $builder->group($groupName, $items);
                }

                $builder->items(NavigationMap::raw());

                return  $builder;
            });

            //TODO crash
//        $this->app->bind('events', 'App\Services\Event\EventService');

            UserMenuItem::make()
                ->label('Аккаунты')
                ->url('shops')
                ->icon('heroicon-s-cog');

            URL::forceScheme('http');//s

            //notification component
            Filament::registerRenderHook(
                'global-search.end',
                fn (): string => Blade::render('@livewire(\'notifications\')')
            );

            //user menu
            Filament::registerUserMenuItems([

                UserMenuItem::make()->url(MyProfile::getUrl()),

                UserMenuItem::make()
                    ->label('Аккаунты')
                    ->url(ShopResource::getUrl())
                    ->icon('heroicon-s-cog'),

                UserMenuItem::make()
                    ->label('Импорт')
                    ->url(ImportResource::getUrl())
                    ->icon('heroicon-s-cog'),

//                UserMenuItem::make()
//                    ->label('Экспорт')
//                    ->url(ShopResource::getUrl())
//                    ->icon('heroicon-s-cog'),
            ]);

            //TODO add in <head>
//            Filament::pushMeta([
//                new HtmlString('<link rel="manifest" href="/site.webmanifest" />'),
//            ]);

//            Filament::registerStyles([
//                asset('css/crm.css'),
//            ]);
        });
    }
}
