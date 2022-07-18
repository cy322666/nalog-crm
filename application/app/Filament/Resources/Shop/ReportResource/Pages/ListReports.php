<?php

namespace App\Filament\Resources\Shop\ReportResource\Pages;

use App\Filament\Resources\Shop\ReportResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
