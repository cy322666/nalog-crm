<?php

namespace App\Modules\Analytics\Widgets;

use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use Filament\Widgets\Widget;
use Illuminate\Support\Arr;

class VisitorsWidget extends Widget
{
    protected static string $view = 'analytics.widgets.visitors-widget';

    protected static ?int $sort = 3;

    public ?string $filter = 'T';

    public bool $readyToLoad = false;

    public function init()
    {
        $this->readyToLoad = true;
    }

    public function label(): ?string
    {
        return __('filament-google-analytics::widgets.visitors');
    }

    protected static function filters(): array
    {
        return [
            'T' => __('filament-google-analytics::widgets.T'),
            'Y' => __('filament-google-analytics::widgets.Y'),
            'LW' => __('filament-google-analytics::widgets.LW'),
            'LM' => __('filament-google-analytics::widgets.LM'),
            'LSD' => __('filament-google-analytics::widgets.LSD'),
            'LTD' => __('filament-google-analytics::widgets.LTD'),
        ];
    }

    protected function initializeData()
    {
        $lookups = [
            'T' => 1,//$this->visitorsToday(),
            'Y' => 1,//$this->visitorsYesterday(),
            'LW' => 1,//$this->visitorsLastWeek(),
            'LM' => 1,//$this->visitorsLastMonth(),
            'LSD' => 1,//$this->visitorsLastSevenDays(),
            'LTD' => 1,//$this->visitorsLastThirtyDays(),
        ];

        $data = Arr::get(
            $lookups,
            $this->filter,
            [
                'result' => 0,
                'previous' => 0,
            ],
        );

        return FilamentGoogleAnalytics::for($data['result'])
            ->previous($data['previous'])
            ->format('%');
    }

    protected function getData(): array
    {
        return [
            'label' => $this->label(),
            'value' => $this->initializeData()->trajectoryValue(),
            'icon' => $this->initializeData()->trajectoryIcon(),
            'color' => $this->initializeData()->trajectoryColor(),
            'description' => $this->initializeData()->trajectoryDescription(),
            'chart' => '',
            'chartColor' => '',
        ];
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->readyToLoad ? $this->getData() : [],
            'filters' => static::filters(),
        ];
    }
}
