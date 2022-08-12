<?php

namespace App\Filament\Resources\Shop\ProductResource\Pages;

use App\Filament\Resources\Shop\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        return ProductResource::getUrl();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (count($data['category']) > 0) {

            $this->record->categories()->attach($data['categories']);
        }

        return $data;
    }
}
