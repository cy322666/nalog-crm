<?php

namespace App\Filament\Resources\Shop\ProductResource\Pages;

use App\Filament\Resources\Shop\ProductResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        return ProductResource::getUrl();
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (count($data['categories']) > 0) {

            foreach ($data['categories'] as $key => $val) {

                $this->record->categories()->attach($val);
            }
        }

        return $data;
    }
}
