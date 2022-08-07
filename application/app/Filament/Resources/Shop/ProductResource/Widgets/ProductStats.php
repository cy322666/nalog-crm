<?php

namespace App\Filament\Resources\Shop\ProductResource\Widgets;

use App\Models\Shop\Product;
use App\Services\CacheService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class ProductStats extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Остатки на складах', number_format(
                CacheService::getAccount()
                    ->products
                    ->sum('qty'), 2)
            ),

            Card::make('Позиций', CacheService::getAccount()->products()->count()),

            Card::make('Остатков на сумму', number_format(
                CacheService::getAccount()
                    ->products
                    ->sum('price'), 2)
            ),
        ];
    }
}
