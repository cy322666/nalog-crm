<?php

namespace App\Filament\Resources\Shop\TaskResource\Widgets;

use App\Models\Shop\Order;
use App\Models\Shop\Task;
use App\Services\CacheService;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TaskStats extends BaseWidget
{
    protected function getCards(): array
    {
        $orderData = Trend::model(Task::class)
            ->between(
                start: now()->subDays(7),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            Card::make('Tasks', Task::query()
                ->where('shop_id', CacheService::getAccountId())
                ->count()
            )->chart(
                $orderData
                    ->map(fn (TrendValue $value) => $value->aggregate)
                    ->toArray()
            )->label('Задач за 7 дней'),
            Card::make('В работе сейчас', Task::query()->where('is_execute', false)->count()),
            Card::make('Просрочено сейчас', Task::query()->where('execute_at', '<', Carbon::now()->format('Y-m-d'))->count()),
        ];
    }
}
