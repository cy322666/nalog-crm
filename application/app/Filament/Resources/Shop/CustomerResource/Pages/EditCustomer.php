<?php

namespace App\Filament\Resources\Shop\CustomerResource\Pages;

use App\Facades\Events;
use App\Filament\Resources\Shop\CustomerResource;
use App\Models\Shop\Customer;
use App\Services\CacheService;
use App\Services\Event\EventDto;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function afterSave(Customer $customer): void
    {
//        Events::set(new EventDto(
//            Customer::class,
//            $customer->id,
//            'Обновление',
//            CacheService::getAccountId(),
//            'updated',
//            Auth::user()->name,
//        ));
    }
}

