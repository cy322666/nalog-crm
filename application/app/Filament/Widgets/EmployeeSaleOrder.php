<?php

namespace App\Filament\Widgets;

use Filament\Widgets\PolarAreaChartWidget;

class EmployeeSaleOrder extends PolarAreaChartWidget
{
    protected static ?string $pollingInterval = null;

    protected static ?string $heading = 'Sales123';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Sales1',
                    'data' => [10, 20, 30]
                ],
//                [
//                    'label' => 'Sales1',
//                    'data' => [15, 25, 35]
//                ]
            ],

//            'backgroundColor'=> [
//        'rgba(255, 99, 132, 0.2)',
//        'rgba(54, 162, 235, 0.2)',
//        'rgba(255, 206, 86, 0.2)',
//        'rgba(75, 192, 192, 0.2)',
//        'rgba(153, 102, 255, 0.2)',
//        'rgba(255, 159, 64, 0.2)'
//    ],
//            'borderColor' => [
//        'rgba(255, 99, 132, 1)',
//        'rgba(54, 162, 235, 1)',
//        'rgba(255, 206, 86, 1)',
//        'rgba(75, 192, 192, 1)',
//        'rgba(153, 102, 255, 1)',
//        'rgba(255, 159, 64, 1)'
//    ],
//            borderWidth: 1

        'labels' => [
            [
                'Red',

            ],
            [
                'Green',
            ],
            [
                'Green',
            ]
            ]
        ];
    }
//    protected function getSlices(): array
//    {
//        return [
//            Slice::make('Flour', 160),//->color('blue'),
//            Slice::make('Sugar', 100),//->color('orange'),
//            Slice::make('Egg', 100),//->color('indigo'),
//            Slice::make('Butter', 40),//->color('yellow'),
//        ];
//    }
}
