<?php

namespace App\Filament\Resources\Shop\PaymentResource\Pages;

use App\Filament\Resources\Shop\PaymentResource;
use Exception;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getRedirectUrl(): string
    {
        return PaymentResource::getUrl();
    }
}
