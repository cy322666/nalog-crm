<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Resources\Pages\CreateRecord;

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
