<?php

namespace App\Filament\Resources\Shop\StockResource\Pages;

use App\Filament\Resources\Shop\StockResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStock extends CreateRecord
{
    protected static string $resource = StockResource::class;
}
