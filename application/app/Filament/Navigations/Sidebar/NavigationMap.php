<?php

namespace App\Filament\Navigations\Sidebar;

use App\Filament\Resources\Shop\CategoryResource;
use App\Filament\Resources\Shop\CustomerResource;
use App\Filament\Resources\Shop\EventResource;
use App\Filament\Resources\Shop\OrderResource;
use App\Filament\Resources\Shop\PaymentResource;
use App\Filament\Resources\Shop\ProductResource;
use App\Filament\Resources\Shop\ReportResource;
use App\Filament\Resources\Shop\ServiceResource;
use App\Filament\Resources\Shop\ShopResource;
use App\Filament\Resources\Shop\StockResource;
use App\Filament\Resources\Shop\TaskResource;
use App\Models\Shop\Shop;
use App\Services\CacheService;
use Filament\Navigation\NavigationItem;

abstract class NavigationMap
{
    /**
     * @return array items from buildings in CrmServiceProvider
     */
    public static function sidebar() : array
    {
        return [
            'Менеджмент' => [
                StockResource::getNavigationItems()[0],
                ProductResource::getNavigationItems()[0],
                CategoryResource::getNavigationItems()[0],
                ServiceResource::getNavigationItems()[0],
            ],
            'Аналитика' => [
//                ReportResource::getNavigationItems()[0],
                EventResource::getNavigationItems()[0],
            ],
//            'Настройки' => [
//                NavigationItem::make('Настройки')
//                    ->url(ShopResource::getUrl('settings', ['record' => CacheService::getAccount()->id]))
//                    ->icon('heroicon-o-cog'),
//            ],
//            'Автоматизация' => [
//                //TODO v2 автоматизация?
//                //TODO v1 settings page
//            ],
        ];
    }

    public static function raw(): array
    {
        return [
            OrderResource::getNavigationItems()[0],
//            TaskResource::getNavigationItems()[0],
            CustomerResource::getNavigationItems()[0],
            PaymentResource::getNavigationItems()[0],
        ];
    }
}
