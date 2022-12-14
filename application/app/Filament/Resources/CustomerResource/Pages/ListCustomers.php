<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected static ?string $navigationGroup = 'Продажи';

    protected function getDeleteBulkAction(): Tables\Actions\BulkAction
    {
        return parent::getDeleteBulkAction()
            ->action(fn () => $this->notify(
                'warning',
                'Now, now, don’t be cheeky, leave some records for others to play with!',
            ));
    }

    protected function getTitle(): string
    {
        return 'Клиенты';
    }

    protected function getTableActions(): array
    {
        //TODO
        return [
            Tables\Actions\ActionGroup::make([
                Tables\Actions\Action::make('email'),
                Tables\Actions\Action::make('inn'),
                Tables\Actions\Action::make('address'),
                Tables\Actions\Action::make('name'),
            ]),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [50, 100];
    }

//    protected function getActions(): array
//    {
//        return [
//            CreateAction::make('sads'),
//        ];
//    }
}
