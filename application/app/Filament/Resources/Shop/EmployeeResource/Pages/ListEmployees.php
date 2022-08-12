<?php

namespace App\Filament\Resources\Shop\EmployeeResource\Pages;

use App\Filament\Resources\Shop\EmployeeResource;
use App\Filament\Resources\Shop\RoleResource;
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
            Actions\Action::make('roles')
                ->label('Роли и права')
                ->url(
                    RoleResource::getUrl()
                ),
            Actions\CreateAction::make(),
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
