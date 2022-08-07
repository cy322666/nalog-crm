<?php

namespace App\Filament\Resources\Shop\OrderResource\Pages;

use App\Filament\Resources\Shop\OrderResource;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderWidgets(): array
    {
        return OrderResource::getWidgets();
    }

    protected function getActions(): array
    {
        return [
            Action::make('settings')
                ->label('Настроить')
                ->color('secondary')
                ->url(OrderResource::getUrl('settings')),
            CreateAction::make(),
        ];
    }


    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [25, 50, 100];
    }

    //фильтры над таблицей
//    protected function getTableFiltersLayout(): ?string
//    {
//        return Tables\Filters\Layout::AboveContent;
//    }
}
