<?php

namespace App\Filament\Resources\Shop\StockResource\Pages;

use App\Filament\Resources\Shop\StockResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStock extends EditRecord
{
    protected static string $resource = StockResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
