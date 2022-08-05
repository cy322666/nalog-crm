<?php

namespace App\Filament\Widgets;

use App\Models\Shop\Order;
use App\Services\CacheService;
use App\Services\Helpers\ReportHelper;
use Carbon\Carbon;
use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Facades\DB;

class OrdersChart extends LineChartWidget
{
    protected static ?string $heading = 'Заказов за месяц';

    protected static ?int $sort = 1;

    private array $dataChart = [
        'datasets' => [[
            'label' => 'Заказы',
            'data'  => [],
        ]],
        'labels' => [],
    ];

    protected function getData(): array
    {
        $collection = $this->prepareData(
            Carbon::now()->subMonth()->format('Y-m-d H:i:s'),
            Carbon::now()->format('Y-m-d H:i:s'),
        );

        foreach ($collection as $dayInfo) {

            $this->dataChart['datasets'][0]['data'][] = $dayInfo->orders_count;
            $this->dataChart['labels'][] = $dayInfo->day;
        }

        return $this->dataChart;
    }

    private function prepareData(string $dayAt, string $dayTo, string $period = 'DAY'): \Illuminate\Support\Collection
    {
        return DB::table((new Order())->getTable())
            ->selectRaw("EXTRACT(DAY FROM created_at) as DAY, COUNT(*) AS orders_count")
            ->where('shop_id', CacheService::getAccountId())
            ->whereBetween('created_at', [
                $dayAt,
                $dayTo
            ])
            ->groupByRaw("DAY")
            ->get();
    }

//    private function prepareData(int $monthAt, int $monthTo): \Illuminate\Support\Collection
//    {
//        return DB::table((new Order())->getTable())
//                ->selectRaw('EXTRACT(MONTH FROM created_at) as MONTH, COUNT(*) AS orders_count')
//                ->where('shop_id', CacheService::getAccountId())
//                ->whereBetween('created_at', [
//                    Carbon::create()->month($monthAt)->format('Y-m-d'),
//                    Carbon::create()->month($monthTo)->format('Y-m-d'),
//                ])
//                ->groupByRaw('MONTH')
//                ->get();
//    }

    private function prepareLabels(int $month)
    {
        for ($i = 0; $i < 12; $i++, $month++) {

            $month = $month > 12 ? 1 : $month;

            $labels[] = ReportHelper::$months[$month];
        }

        return $labels;
    }
}


