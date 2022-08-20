<?php

namespace App\Filament\Widgets\Analytics;


use JQHT\FilamentStaticChartWidgets\Widgets\PieChartWidget;
use JQHT\FilamentStaticChartWidgets\Widgets\PieChartWidget\Slice;

class CakeCompositionChart extends PieChartWidget
{
    public bool $showTotalLabel = true;

    public string $size = 'lg';

    protected function getHeading():string
    {
        return 'Cake Composition';
    }

    protected function getSlices(): array
    {
        return [
            Slice::make('Flour', 160),//->color('blue'),
            Slice::make('Sugar', 100),//->color('orange'),
            Slice::make('Egg', 100),//->color('indigo'),
            Slice::make('Butter', 40),//->color('yellow'),
        ];
    }
}
