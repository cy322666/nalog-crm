<?php

namespace App\Filament\Resources\Shop\TaskResource\Widgets;

use App\Models\Shop\Order;
use App\Models\Shop\Task;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

/**
 * Показатели задач на странице задач
 */
class TaskStats extends BaseWidget
{
    //TODO params query shop_id
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
            Card::make('Tasks', Task::query()//TODO?
                ->count())
                ->chart(
                    $orderData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
//            Card::make('В работе', Task::query()->where('execute', false)->count()),
//            Card::make('Просрочено', Task::query()->where('execute_at', '<', Carbon::now()->format('Y-m-d'))->count()),
        ];
    }
}
