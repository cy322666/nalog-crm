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
        $shop = CacheService::getAccount();

        return [
            Card::make('without_tasks', Order::query()//TODO
                ->where('shop_id', CacheService::getAccountId())
                ->count())
                ->color('warning')
                ->label('Заказов без задачи'),

            Card::make('in_work_count', $shop->orders()->where('closed', false)->count())
                ->label('В работе'),

            Card::make('in_work_sum', $shop->orders()->where('closed', false)->sum('price'), 2)
                ->label('В работе на сумму'),
        ];
    }
}
