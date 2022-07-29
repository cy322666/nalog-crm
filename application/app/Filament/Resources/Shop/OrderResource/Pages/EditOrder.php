<?php

namespace App\Filament\Resources\Shop\OrderResource\Pages;

use Ably\Log;
use App\Filament\Resources\Shop\OrderResource;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        \Illuminate\Support\Facades\Log::info(__METHOD__, $data);

        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['unit_price'] * $item['qty'];
        }

        $data['total_price'] = $total;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return OrderResource::getUrl();
    }
}
