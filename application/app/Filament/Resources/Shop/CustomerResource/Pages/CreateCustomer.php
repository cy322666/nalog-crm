<?php

namespace App\Filament\Resources\Shop\CustomerResource\Pages;

use App\Events\Shop\EntityEvent;
use App\Filament\Resources\Shop\CustomerResource;
use App\Services\Event\EventManager;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getTitle(): string
    {
        return 'Создать клиента';
    }

    protected function getRedirectUrl(): string
    {
        return CustomerResource::getUrl();
    }
}
