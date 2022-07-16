<?php

namespace App\Filament\Resources\Shop\StatusResource;

use App\Filament\Resources\Shop\StatusResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;

class CreateStatuses extends CreateRecord
{
    protected static string $resource = StatusResource::class;

    protected function getActions(): array
    {
        return [];
    }
}
