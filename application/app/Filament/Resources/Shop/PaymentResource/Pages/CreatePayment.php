<?php

namespace App\Filament\Resources\Shop\PaymentResource\Pages;

use App\Filament\Resources\Shop\PaymentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;
}
