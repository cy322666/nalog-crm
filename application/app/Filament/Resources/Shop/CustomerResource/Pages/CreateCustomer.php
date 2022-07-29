<?php

namespace App\Filament\Resources\Shop\CustomerResource\Pages;

use App\Facades\EventLogger;
use App\Filament\Resources\Shop\CustomerResource;
use App\Services\CacheService;
use App\Services\Event\EventDto;
use App\Services\Event\EventService;
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

    protected function afterCreate(): void
    {
        EventLogger::set(new EventDto(
            CustomerResource::MODEL_TYPE,
            $this->record->id,
            EventService::CUSTOMER_CREATED_TEXT,
            CacheService::getAccountId(),
            EventService::CREATED_TYPE,
            Auth::user()->name,
        ));
    }
}
