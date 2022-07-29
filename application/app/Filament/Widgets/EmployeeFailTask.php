<?php

namespace App\Filament\Widgets;

use Filament\Widgets\DoughnutChartWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class EmployeeFailTask extends DoughnutChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Fail tasks',
                    'data'  => [4344, 5676, 6798, 7890, 8987],
                ],
            ],
            'labels' => ['vasya', 'vasya1', 'vasya2', 'vasya3', 'vasya4'],
            'colors' => [
                'primary',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
            ],
        ];
    }
}
