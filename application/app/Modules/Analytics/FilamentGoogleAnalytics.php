<?php

namespace BezhanSalleh\FilamentGoogleAnalytics;

use Illuminate\Support\Carbon;

class FilamentGoogleAnalytics
{
    public string $previous;
    public string $format;

    public function __construct(public ?string $value = null)
    {
    }

    public static function for(?string $value = null)
    {
        return new static($value);
    }

    public function previous(string $previous): static
    {
        $this->previous = $previous;

        return $this;
    }

    public function format(string $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function compute(): int
    {
        if ($this->value == 0 || $this->previous == 0 || $this->previous == null) {
            return 0;
        }

        return (((int)$this->value - (int)$this->previous) / (int)$this->previous) * 100;//TODO (int)
    }

    public function trajectoryValue(): int|string
    {
        return static::thousandsFormater($this->value);
    }

    public function trajectoryValueAsTimeString(): string
    {
        return Carbon::createFromTimestamp($this->value)->toTimeString();
    }

    public function trajectoryLabel(): array|string|\Illuminate\Contracts\Translation\Translator|\Illuminate\Contracts\Foundation\Application|null
    {
        return match ($this->compute()) {
            -1      => 'heroicon-o-trending-up',//=> __('analytics.widgets.trending_down'),
            1       => 'heroicon-o-trending-down',//=> __('analytics.widgets.trending_up'),
            default => 'heroicon-o-switch-horizontal',//=> __('analytics.widgets.steady')
        };
    }

    public function trajectoryColor()
    {
        return match ($this->compute()) {
            -1      => 'danger',//config('filament-google-analytics.trending_down_color'),
            1       => 'success',//config('filament-google-analytics.trending_up_color'),
            default => 'secondary',//config('filament-google-analytics.trending_steady_color')
        };
    }

    public function trajectoryIcon()
    {
        return match ($this->compute()) {
            1       => 'heroicon-o-trending-up',//=> __=> config('filament-google-analytics.trending_up_icon'),
            -1      => 'heroicon-o-trending-down',//=> => config('filament-google-analytics.trending_down_icon'),
            default => 'heroicon-o-switch-horizontal',// config('filament-google-analytics.steady_icon')
        };
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function trajectoryDescription(): string
    {
        return static::thousandsFormater(abs($this->compute())) . $this->format . ' ' .$this->trajectoryLabel();
    }

    public static function thousandsFormater($value): int|string
    {
        $number = (int) $value;

        if ($number > 1000) {
            $x = round($number);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = ['k', 'm', 'b', 't'];
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;
        }

        return $number;
    }
}
