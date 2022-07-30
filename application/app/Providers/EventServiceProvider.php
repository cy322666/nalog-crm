<?php

namespace App\Providers;

use App\Events\Shop\EntityEvent;
use App\Listeners\AddEventEntity;
use App\Models\Shop\Task;
use App\Observers\Shop\TaskObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        //сущность в системе создана/изменена/удалена
        EntityEvent::class => [
            AddEventEntity::class,  //добавление события в event storage
        ],
//        'Illuminate\Notifications\Events\NotificationSending' => [
//            'App\Listeners\CheckNotificationStatus',
//        ],

    ];

    protected $observers = [
        //Task::class => [TaskObserver::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
