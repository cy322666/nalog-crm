<?php

namespace App\Filament\Resources\Shop\OrderResource\Widgets;

use App\Models\Shop\Order;
use App\Services\CacheService;
use Carbon\Carbon;
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
        $shop = null;

        return [
            Card::make('without_tasks', $shop->orders()->whereDate('created_at', date('Y-m-d'))->count())
                ->label('Заказов сегодня'),

            Card::make('in_work_count', $shop->orders()->where('closed', false)->count())
                ->label('В работе'),

            Card::make('in_work_sum', $shop->orders()->where('closed', false)->sum('price'))
                ->label('В работе на сумму'),
        ];
    }
}
