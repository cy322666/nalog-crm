<?php

namespace App\Modules\Analytics\Widgets;

use App\Modules\Analytics\AnalyticsClient;
use App\Modules\Analytics\AnalyticsService;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use Filament\Widgets\Widget;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Modules\Analytics\Analytics;
use App\Modules\Analytics\Period;

class SessionsByDeviceWidget extends Widget
{
    protected static string $view = 'analytics.widgets.sessions-by-device-widget';

    protected static ?int $sort = 3;

    public ?string $total = null;

    public bool $readyToLoad = false;

    public function init()
    {
        $this->readyToLoad = true;
    }

    protected function label(): ?string
    {
        return 'by device';//__('analytics.widgets.sessions_by_device');
    }

    protected function getChartData()
    {
        //app(Analytics::class)
//        $analyticsData = (new Analytics(new AnalyticsClient(new AnalyticsService(), Cache::store('redis')), 1))->performQuery(
//            Period::months(1),
//            'ga:sessions',
//            [
//                'metrics' => 'ga:sessions',
//                'dimensions' => 'ga:deviceCategory',
//            ]
//        );
//
//        $results = [];
//        foreach (collect($analyticsData->getRows()) as $row) {
//            $results[Str::studly($row[0])] = $row[1];
//        }
//
//        $this->total = number_format($analyticsData->totalsForAllResults['ga:sessions']);

        return [
            'labels' => array_keys(['123', 1, 2, 3, 4]),
            'datasets' => [
                [
                    'label' => 'Device',
                    'data' => array_map('intval', array_values([1,2,3,4,5=>1])),
                    'backgroundColor' => [
                        '#008FFB', '#00E396', '#feb019', '#ff455f', '#775dd0', '#80effe',
                    ],
                    'cutout' => '75%',
                    'hoverOffset' => 7,
                    'borderColor' => config('filament.dark_mode') ? 'transparent' : '#fff',

                ],
            ],
        ];
    }

    protected function getOptions(): ?array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'left',
                    'align' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                    ],
                ],
            ],
            'maintainAspectRatio' => false,
            'radius' => '70%',
            'borderRadius' => 4,
            'cutout' => 95,
            'scaleBeginAtZero' => true,
        ];
    }

    protected function getData()
    {
        return [
            'chartData' => $this->getChartData(),
            'chartOptions' => $this->getOptions(),
            'total' => $this->total,
        ];
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->readyToLoad ? $this->getData() : [],
        ];
    }
}
