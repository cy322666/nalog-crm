<?php

namespace App\Observers\Shop;

use App\Events\Shop\EntityEvent;
use App\Models\Shop\Order;
use App\Models\User;
use App\Services\Event\EventManager;

class OrderObserver
{
    public function created(Order $order)
    {
        event(new EntityEvent(
            User::query()->find($order->creator_id)->first(),
            $order,
            EventManager::orderCreated(),
        ));
    }

    public function updated(Order $order)
    {
        //
    }

    public function deleted(Order $order)
    {
        //
    }
}
