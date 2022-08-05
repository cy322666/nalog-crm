<?php

namespace App\Filament\Resources\Shop\ReportResource\Pages;

use App\Filament\Resources\Shop\ReportResource;
use App\Filament\Widgets\Analytics\EmployeeOrdersChart;
use App\Filament\Widgets\Analytics\EmployeeTasksChart;
use App\Filament\Widgets\Analytics\LostOrdersChart;
use App\Filament\Widgets\Analytics\PaymentsChart;
use App\Filament\Widgets\Analytics\SourceOrdersChart;
use App\Filament\Widgets\EmployeeFailTask;
use App\Filament\Widgets\EmployeeOrder;
use App\Filament\Widgets\EmployeeSaleOrder;
use App\Filament\Widgets\OrdersChart;
use App\Filament\Widgets\OrderSource;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\StatusOrder;
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
use Exception;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected static string $view = 'filament.pages.analytics';

    /**
     * @throws Exception
     */
    protected function getActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PageViewsWidget::class,
            ActiveUsersOneDayWidget::class,
            PaymentsChart::class,
            OrdersChart::class,
            StatusOrder::class,
            EmployeeOrder::class,

            SessionsByDeviceWidget::class,
            StatsOverviewWidget::class,

            OrderSource::class,
            EmployeeOrder::class,

//            EmployeeFailTask::class,

            EmployeeSaleOrder::class,

//            SourceOrdersChart::class,
//            LostOrdersChart::class,
//            EmployeeTasksChart::class,
//            EmployeeOrdersChart::class,

//            VisitorsWidget::class,
//            ActiveUsersSevenDayWidget::class,
//            ActiveUsersFourteenDayWidget::class,
//            ActiveUsersTwentyEightDayWidget::class,
//            SessionsWidget::class,
//            SessionsDurationWidget::class,
//            SessionsByCountryWidget::class,
//            MostVisitedPagesWidget::class,

            TopReferrersListWidget::class,
        ];
    }
}
