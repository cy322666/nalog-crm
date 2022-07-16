<?php

namespace App\Providers;

use App\Http\Livewire\Notification;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;

class NotificationProvider extends ServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('notification')
            ->hasConfigFile('crm-notification')
            ->hasTranslations()
            ->hasViewComponents('notification')
            ->hasViews();
    }

    public function packageBooted(): void
    {
        $this->bootLivewireComponents();
    }

    protected function bootLivewireComponents(): void
    {
        Livewire::component('notification.feed', Notification::class);
    }
}
