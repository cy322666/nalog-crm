<?php

namespace App\Observers\Shop;

use App\Events\Shop\EntityEvent;
use App\Models\Shop\Customer;
use App\Models\User;
use App\Services\Event\EventManager;

class CustomerObserver
{
    public function created(Customer $customer)
    {
        event(new EntityEvent(
            User::query()->find($customer->creator_id)->first(),
            $customer,
            EventManager::clientCreated(),
        ));
    }

    public function updated(Customer $customer)
    {
        //
    }

    public function deleted(Customer $customer)
    {
        //
    }
}
