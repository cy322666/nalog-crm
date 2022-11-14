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

    protected function beforeCreate(): void
    {
        Log::info(__METHOD__, [$this->data]);
    }

    protected function beforeValidate(): void
    {
        Log::info(__METHOD__, [$this->data]);
    }

    protected function afterValidate(): void
    {
        Log::info(__METHOD__, [$this->data]);
    }

    protected function afterCreate(): void
    {
        Log::info(__METHOD__, [$this->data]);
    }
}
