<?php

namespace App\Filament\Resources\Shop\CustomerResource\Pages;

use App\Facades\EventLogger;
use App\Filament\Resources\Shop\CustomerResource;
use App\Services\CacheService;
use App\Services\Event\EventDto;
use App\Services\Event\EventService;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function afterSave(): void
    {
        EventLogger::set(new EventDto(
            CustomerResource::MODEL_TYPE,
            $this->record->id,
            EventService::CUSTOMER_UPDATED_TEXT,
            CacheService::getAccountId(),
            EventService::UPDATED_TYPE,
            Auth::user()->name,
        ));
    }

    protected function getRedirectUrl(): string
    {
        return CustomerResource::getUrl('view', ['record' => $this->record]);
    }
}

