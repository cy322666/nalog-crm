<?php

namespace App\Filament\Resources\Shop\EmployeeResource\Pages;

use App\Filament\Resources\Shop\EmployeeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected int|string|array $columnSpan = '5xl';//TODO dont work

    protected function getTitle(): string
    {
        return 'Сотрудники';
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
