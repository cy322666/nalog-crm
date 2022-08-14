<?php

namespace App\Observers\Shop;

use App\Events\Shop\EntityEvent;
use App\Models\Shop\Payment;
use App\Models\User;
use App\Services\Event\EventManager;

class ProductObserver
{
    public function created(Payment $payment)
    {
        event(new EntityEvent(
            User::query()->find($payment->creator_id)->first(),
            $payment,
            EventManager::productCreated(),
        ));
    }

    public function updated(Payment $payment)
    {
        //
    }

    public function deleted(Payment $payment)
    {
        //
    }
}
