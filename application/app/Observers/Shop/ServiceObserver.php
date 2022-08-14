<?php

namespace App\Observers\Shop;

use App\Events\Shop\EntityEvent;
use App\Models\Shop\Payment;
use App\Models\Shop\Service;
use App\Models\User;
use App\Services\Event\EventManager;

class ServiceObserver
{
    public function created(Service $service)
    {
        event(new EntityEvent(
            User::query()->find($service->creator_id)->first(),
            $service,
            EventManager::serviceCreated(),
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
