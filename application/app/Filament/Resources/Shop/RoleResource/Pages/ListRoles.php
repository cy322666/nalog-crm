<?php

namespace App\Filament\Resources\Shop\RoleResource\Pages;

use App\Filament\Resources\Shop\EmployeeResource;
use App\Filament\Resources\Shop\RoleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('employees')
                ->label('Сотрудники')
                ->url(EmployeeResource::getUrl()),

            Actions\CreateAction::make(),
        ];
    }
}
