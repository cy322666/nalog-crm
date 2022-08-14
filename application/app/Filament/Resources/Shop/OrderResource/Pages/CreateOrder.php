<?php

namespace App\Filament\Resources\Shop\OrderResource\Pages;

use App\Events\Shop\EntityEvent;
use App\Filament\Resources\Shop\OrderResource;
use App\Services\Event\EventManager;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        //TODO бюджет пересчитывает?
//        $total = 0;
//        foreach ($data['items'] as $item) {
//            $total += $item['unit_price'] * $item['qty'];
//        }
//
//        $data['total_price'] = $total;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return OrderResource::getUrl();
    }
}
