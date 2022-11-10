<?php

namespace App\Filament\Resources\Shop\ImportResource\Pages;

use App\Filament\Resources\Shop\ImportResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListImports extends ListRecords
{
    protected static string $resource = ImportResource::class;

//    protected function getActions(): array
//    {
//        return [
//            Actions\CreateAction::make(),
//        ];
//    }
    protected function getActions(): array
    {
        return [
            ImportAction::make()
                ->fields([
                    ImportField::make('project')
                        ->label('Project')
                        ->helperText('Define as project helper'),
                    ImportField::make('manager')
                        ->label('Manager'),
                ])
        ];
    }
}
