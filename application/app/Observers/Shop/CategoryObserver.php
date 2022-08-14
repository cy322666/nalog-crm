<?php

namespace App\Observers\Shop;

use App\Events\Shop\EntityEvent;
use App\Models\Shop\Customer;
use App\Models\User;
use App\Services\Event\EventManager;

class CategoryObserver
{
    public function created(Customer $customer)
    {
        event(new EntityEvent(
            User::query()->find($customer->creator_id)->first(),
            $customer,
            EventManager::categoryCreated(),
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
