<?php

namespace App\Filament\Resources\Shop\TaskTypeResource\Pages;

use App\Filament\Resources\Shop\TaskTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;

class ListTaskTypes extends ListRecords
{
    protected static string $resource = TaskTypeResource::class;

        protected ?string $maxContentWidth = '5xl';

    protected function getTitle(): string
    {
        return 'Типы задач';
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
