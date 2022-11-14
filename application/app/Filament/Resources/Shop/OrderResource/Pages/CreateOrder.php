<?php

namespace App\Filament\Resources\Shop\OrderResource\Pages;

use App\Events\Shop\EntityEvent;
use App\Filament\Resources\Shop\OrderResource;
use App\Services\Event\EventManager;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function getRedirectUrl(): string
    {
        return OrderResource::getUrl();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        Log::info(__METHOD__, $data);

        return $data;
    }
}
