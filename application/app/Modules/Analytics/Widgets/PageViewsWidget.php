<?php

namespace App\Modules\Analytics\Widgets;
use Filament\Widgets\Widget;
use Illuminate\Support\Arr;

class PageViewsWidget extends Widget
{
    protected static string $view = 'analytics.widgets.page-views-widget';

    protected static ?int $sort = 3;

    public ?string $filter = 'T';

    public $readyToLoad = false;

    public function init()
    {
        $this->readyToLoad = true;
    }

    public function label(): ?string
    {
        return 'label';//__('analytics.widgets.page_views');
    }

    protected static function filters(): array
    {
        return [
            'T' => 'Today',
            'Y' => 'Yesterday',
            'TW' => 'This Week',
            'LW' => 'Last Week',
            'LM' => 'Last Month',
            'TM' => 'This Month',
            'TY' => 'This Year',
            'LSD' => 'Last 7 Days',
            'LTD' => 'Last 30 Days',
            'FD' => '5 Days',
            'TD' => '10 Days',
            'FFD' => '15 Days',
        ];
    }

    protected function initializeData()
    {
        $lookups = [
            'T' => 1,//$this->pageViewsToday(),
            'Y' => 1,//$this->pageViewsYesterday(),
            'LW' => 1,//$this->pageViewsLastWeek(),
            'LM' => 1,//$this->pageViewsLastMonth(),
            'LSD' => 1,//$this->pageViewsLastSevenDays(),
            'LTD' => 1,//$this->pageViewsLastThirtyDays(),
        ];

        $data = Arr::get(
            $lookups,
            $this->filter,
            [
                'result' => 0,
                'previous' => 0,
            ],
        );

        return \App\Modules\Analytics\FilamentGoogleAnalytics::for($data['result'] ?? 'ok')
            ->previous($data['previous'] ?? 1)
            ->format('%');
    }

    protected function getData(): array
    {
        return [
            'value' => $this->initializeData()->trajectoryValue(),
            'icon' => $this->initializeData()->trajectoryIcon(),
            'color' => $this->initializeData()->trajectoryColor(),
            'description' => $this->initializeData()->trajectoryDescription(),
            'chart' => [],
            'chartColor' => '',
        ];
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->getData(),
                //$this->readyToLoad ? $this->getData() : [],
            'filters' => static::filters(),
        ];
    }
}
