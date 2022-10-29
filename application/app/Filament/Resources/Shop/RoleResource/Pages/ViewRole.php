<?php

namespace App\Filament\Resources\Shop\RoleResource\Pages;

use App\Filament\Resources\Shop\RoleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('index')
                ->label('Все роли')
                ->url(RoleResource::getUrl()),

            Actions\EditAction::make(),
        ];
    }
}
