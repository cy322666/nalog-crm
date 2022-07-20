<?php

namespace App\Filament\Resources\Shop\ServiceResource\Pages;

use App\Filament\Resources\Shop\ServiceResource;
use Exception;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    /**
     * @throws Exception
     */
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTitle(): string
    {
        return 'Услуги';
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [25, 50, 100, 150];
    }
}
