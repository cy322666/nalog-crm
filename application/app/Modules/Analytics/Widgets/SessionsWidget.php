<?php

namespace App\Modules\Analytics\Widgets;

use BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalytics;
use BezhanSalleh\FilamentGoogleAnalytics\Traits;
use Filament\Widgets\Widget;
use Illuminate\Support\Arr;

class SessionsWidget extends Widget
{
    protected static string $view = 'analytics.widgets.sessions-widget';

    protected static ?int $sort = 3;

    public ?string $filter = 'T';

    public $readyToLoad = false;

    public function init()
    {
        $this->readyToLoad = true;
    }

    public function label(): ?string
    {
        return __('filament-google-analytics::widgets.sessions');
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
            'T' => 1,//$this->sessionsToday(),
            'Y' => 1,//$this->sessionsYesterday(),
            'LW' => 1,//$this->sessionsLastWeek(),
            'LM' => 1,//$this->sessionsLastMonth(),
            'LSD' => 1,//$this->sessionsLastSevenDays(),
            'LTD' => 1,//$this->sessionsLastThirtyDays(),
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
            'data' => $this->readyToLoad ? $this->getData() : [],
            'filters' => static::filters(),
        ];
    }
}
