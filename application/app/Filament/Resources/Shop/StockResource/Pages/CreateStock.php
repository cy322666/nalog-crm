<?php

namespace App\Filament\Resources\Shop\StockResource\Pages;

use App\Filament\Resources\Shop\StockResource;
use App\Services\CacheService;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStock extends CreateRecord
{
    protected static string $resource = StockResource::class;

    protected function getRedirectUrl(): string
    {
        return StockResource::getUrl();
    }
}
