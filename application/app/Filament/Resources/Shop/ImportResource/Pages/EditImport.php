<?php

namespace App\Filament\Resources\Shop\ImportResource\Pages;

use App\Filament\Resources\Shop\ImportResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImport extends EditRecord
{
    protected static string $resource = ImportResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
