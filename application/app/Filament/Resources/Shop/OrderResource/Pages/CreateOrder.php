<?php

namespace App\Filament\Resources\Shop\OrderResource\Pages;

use App\Events\Shop\EntityEvent;
use App\Filament\Resources\Shop\OrderResource;
use App\Services\Event\EventManager;
use Carbon\Carbon;
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
        $this->data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $this->data['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

        return $this->data;
    }
}
