<?php

namespace App\Filament\Navigations\Sidebar;

use App\Filament\Resources\ContractResource;
use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\PaymentResource;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\TaskResource;

abstract class NavigationMap
{
    /**
     * @return array items from buildings in CrmServiceProvider
     */
    public static function sidebar() : array
    {
        return [
            '' => [
                CustomerResource::getNavigationItems()[0],
                ContractResource::getNavigationItems()[0],
                ProductResource::getNavigationItems()[0],
                TaskResource::getNavigationItems()[0],
                PaymentResource::getNavigationItems()[0],
            ],
//            'Аналитика' => [
//                ReportResource::getNavigationItems()[0],
//                EventResource::getNavigationItems()[0],
//            ],
//            'Настройки' => [
//                NavigationItem::make('Настройки')
//                    ->url(ShopResource::getUrl('settings', ['record' => CacheService::getAccount()->id]))
//                    ->icon('heroicon-o-cog'),
        ];
    }

    public static function raw(): array
    {
        return [
//            OrderResource::getNavigationItems()[0],
//            TaskResource::getNavigationItems()[0],
//            CustomerResource::getNavigationItems()[0],
//            PaymentResource::getNavigationItems()[0],
        ];
    }
}
