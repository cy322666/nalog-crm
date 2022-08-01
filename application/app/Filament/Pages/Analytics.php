<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\Analytics\CountNewOrdersChart;
use App\Filament\Widgets\ListShopsWidget;
use App\Modules\Analytics\Widgets\ActiveUsersFourteenDayWidget;
use App\Modules\Analytics\Widgets\ActiveUsersOneDayWidget;
use App\Modules\Analytics\Widgets\ActiveUsersSevenDayWidget;
use App\Modules\Analytics\Widgets\ActiveUsersTwentyEightDayWidget;
use App\Modules\Analytics\Widgets\MostVisitedPagesWidget;
use App\Modules\Analytics\Widgets\PageViewsWidget;
use App\Modules\Analytics\Widgets\SessionsByCountryWidget;
use App\Modules\Analytics\Widgets\SessionsByDeviceWidget;
use App\Modules\Analytics\Widgets\SessionsDurationWidget;
use App\Modules\Analytics\Widgets\SessionsWidget;
use App\Modules\Analytics\Widgets\TopReferrersListWidget;
use App\Modules\Analytics\Widgets\VisitorsWidget;
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
//    protected function getHeaderWidgets(): array
//    {
//        return [
//            CountNewOrdersChart::class,
//        ];
//    }
    protected function getHeaderWidgets(): array
    {
        return [
//            PageViewsWidget::class,
//            VisitorsWidget::class,
//            ActiveUsersOneDayWidget::class,
//            ActiveUsersSevenDayWidget::class,
//            ActiveUsersFourteenDayWidget::class,
//            ActiveUsersTwentyEightDayWidget::class,
//            SessionsWidget::class,
//            SessionsDurationWidget::class,
//            SessionsByCountryWidget::class,
//            SessionsByDeviceWidget::class,
//            MostVisitedPagesWidget::class,
//            TopReferrersListWidget::class,
        ];
    }
}
