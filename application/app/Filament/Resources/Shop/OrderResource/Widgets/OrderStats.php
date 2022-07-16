<?php

namespace App\Filament\Resources\Shop\OrderResource\Widgets;

use App\Models\Shop\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

/**
 * Показатели заказов на странице заказов
 */
class OrderStats extends BaseWidget
{
    //TODO params query shop_id
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
                ->count())
                ->chart(
                    $orderData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
            Card::make('В работе', Order::query()->where('closed', false)->count()),
            Card::make('Средний чек', number_format(Order::avg('total_price'), 2)),
        ];
    }
}
