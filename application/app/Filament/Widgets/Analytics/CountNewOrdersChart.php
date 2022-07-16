<?php

namespace App\Filament\Widgets\Analytics;

use App\Models\Shop\Order;
use Carbon\Carbon;
use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Facades\DB;

class CountNewOrdersChart extends LineChartWidget
{
    protected static ?string $heading = 'Созданные заказы';

    protected static ?string $pollingInterval = '15s';

    public ?string $filter = 'month';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Сегодня',
            'week'  => 'Неделя',
            'month' => 'Месяц',
            'year'  => 'Год',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;

//        $orders = DB::table('shop_orders')
//            ->select('*')
//            ->whereBetween('created_at', [
//                Carbon::create('2022', '01', '01'),
//                Carbon::create('2022', '02', '01'),
//            ])
//            ->groupBy('status')
//            ->get();

//            ->selectRaw('*, count(id)')
//            ->whereBetween('created_at', [
//                Carbon::create('2022', '01', '01'),
//                Carbon::create('2022', '02', '01'),
//            ])
//            ->groupBy('status')
//            ->get();


//            ->select('*, count()')
//
//            ->groupBy('status')
//            ->get();


//        dd($orders);

        return [
            'datasets' => [
                [
                    'label' => 'Заказы',
                    'data'  => [
                        4344, 5676, 6798, 7890, 8987, 9388, 10343, 10524, 13664, 14345, 15753],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        ];
    }
}
