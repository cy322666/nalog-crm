<?php

namespace App\Filament\Resources\Shop\CustomerResource\Pages;

use App\Events\Shop\EntityEvent;
use App\Facades\EventLogger;
use App\Filament\Resources\Shop\CustomerResource;
use App\Services\CacheService;
use App\Services\Event\EventDto;
use App\Services\Event\EventManager;
use App\Services\Event\EventService;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function afterSave(): void
    {
        event(new EntityEvent(
            Auth::user(),
            $this->getMountedActionFormModel(),
            EventManager::clientUpdated(),
        ));
    }

    protected function getRedirectUrl(): string
    {
        return CustomerResource::getUrl();
    }
}

