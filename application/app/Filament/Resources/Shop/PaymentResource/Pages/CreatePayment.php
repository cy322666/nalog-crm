<?php

namespace App\Filament\Resources\Shop\PaymentResource\Pages;

use App\Events\Shop\EntityEvent;
use App\Filament\Resources\Shop\PaymentResource;
use App\Models\Shop\Payment;
use App\Services\Event\EventManager;
use App\Services\Helpers\ModelHelper;
use Exception;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    /**
     * @throws Exception
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        PaymentResource::createActions($data);

        return $data;
    }
}
