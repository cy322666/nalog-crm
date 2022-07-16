<?php

namespace App\Filament\Resources\Shop\EmployeeResource\Pages;

use App\Filament\Resources\Shop\EmployeeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
