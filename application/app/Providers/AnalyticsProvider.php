<?php

namespace App\Providers;

use App\Filament\Pages\Analytics;
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
use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class AnalyticsProvider extends PluginServiceProvider
{
    protected array $pages = [
        Analytics::class,
    ];

    protected array $widgets = [
        PageViewsWidget::class,
        VisitorsWidget::class,
        ActiveUsersOneDayWidget::class,
        ActiveUsersSevenDayWidget::class,
        ActiveUsersFourteenDayWidget::class,
        ActiveUsersTwentyEightDayWidget::class,
        SessionsWidget::class,
        SessionsDurationWidget::class,
        SessionsByCountryWidget::class,
        SessionsByDeviceWidget::class,
        MostVisitedPagesWidget::class,
        TopReferrersListWidget::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('crm-analytics')
//            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations();
    }
}
