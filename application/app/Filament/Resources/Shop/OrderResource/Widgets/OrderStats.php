<?php

namespace App\Filament\Resources\Shop\OrderResource\Widgets;

use App\Models\Shop\Order;
use App\Services\CacheService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

/**
 * Показатели заказов на странице заказов
 */
class OrderStats extends BaseWidget
{
    protected function getCards(): array
    {
        $orderData = Trend::model(Order::class)
            ->between(
                start: now()->subDays(7),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            Card::make('Orders', Order::query()
                ->where('shop_id', CacheService::getAccountId())
                ->count())
                ->label('Всего заказов')
                ->chart(
                    $orderData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
            Card::make('В работе',
                Order::query()
                    ->where('shop_id', CacheService::getAccountId())
                    ->where('closed', false)
                    ->count()),

            Card::make('Выиграно на сумму', number_format(
                Order::query()
                    ->where('closed', true)
                    ->where('shop_id', CacheService::getAccountId())
                    ->sum('price'), 2)
            ),
        ];
    }
}
