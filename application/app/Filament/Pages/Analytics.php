<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\Analytics\CountNewOrdersChart;
use App\Filament\Widgets\ListShopsWidget;
use Filament\Forms\Components\Card;
use Filament\Pages\Page;
use Filament\Widgets\AccountWidget;

class Analytics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';

    protected static string $view = 'filament.pages.analytics';

    protected function getTitle(): string
    {
        return 'Аналитика';
    }

    //задачи по сотрудникам/просроченных
    //+ платежи
    //получено за время
    //+ по источникам
    //+ причины отказа
    //+ заказов по сотрудникам в работе
    protected function getHeaderWidgets(): array
    {
        return [
            CountNewOrdersChart::class,
        ];
    }
}
