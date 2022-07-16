<?php

namespace App\Filament\Resources\Shop\EventResource\Pages;

use App\Filament\Resources\Shop\EventResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected function getActions(): array
    {
        return [];
    }

    protected function getTitle(): string
    {
        return 'События';
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [50, 100, 150];
    }
}
