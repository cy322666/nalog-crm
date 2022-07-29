<?php

namespace App\Filament\Widgets;

use Filament\Widgets\PolarAreaChartWidget;

class EmployeeSaleOrder extends PolarAreaChartWidget
{
    protected static ?string $heading = 'Sales';

    protected function getData(): array
    {
        return [

            'datasets' => [
                'label' => 'Sales',
                'data' => [10, 20, 30, 10, 15]
            ],

        'labels' => [
            'Red',
            'Green',
            'Yellow',
            'Grey',
            'Blue'
            ]
        ];
    }
}
