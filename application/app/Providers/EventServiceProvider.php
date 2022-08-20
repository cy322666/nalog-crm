<?php

namespace App\Providers;

use App\Events\Shop\EntityEvent;
use App\Listeners\AddEventEntity;
use App\Models\Shop\Category;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\Payment;
use App\Models\Shop\Product;
use App\Models\Shop\Service;
use App\Models\Shop\Task;
use App\Observers\Shop\CategoryObserver;
use App\Observers\Shop\CustomerObserver;
use App\Observers\Shop\OrderObserver;
use App\Observers\Shop\PaymentObserver;
use App\Observers\Shop\ProductObserver;
use App\Observers\Shop\ServiceObserver;
use App\Observers\Shop\TaskObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
//        Task::class     => [TaskObserver::class],
//        Payment::class  => [PaymentObserver::class],
//        Order::class    => [OrderObserver::class],
//        Category::class => [CategoryObserver::class],
//        Product::class  => [ProductObserver::class],
//        Customer::class => [CustomerObserver::class],
//        Service::class  => [ServiceObserver::class],
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
