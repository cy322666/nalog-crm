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
            Card::make('На сегодня', Task::query()
                ->whereBetween('execute_to', [
                    Carbon::now()->format('Y-m-d').' 00:00:00',
                    Carbon::now()->format('Y-m-d').' 23:59:59',
                ])->count()),

            Card::make('В работе', Task::query()->where('is_execute', false)->count()),

            Card::make('Просрочено', Task::query()->where('execute_at', '<', Carbon::now()->format('Y-m-d'))->count()),
        ];
    }
}
