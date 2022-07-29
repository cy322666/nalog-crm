<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BubbleChartWidget;

class EmployeeOrder extends BubbleChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Employees',
                    'data' => [
                        [
                         'x' => 0,7,
                         'y' => 1,2,
                         'r' => 3,
                    ],
                    [
                        'x' => 1,0,
                        'y' => 2,1,
                        'r' => 3,
                    ],
                    [
                        'x' => 0,5,
                        'y' => 1,7,
                        'r' => 10,
                    ],
                ]],
            ],
        ];
    }
}
