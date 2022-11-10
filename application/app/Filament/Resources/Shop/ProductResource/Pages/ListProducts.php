<?php

namespace App\Filament\Resources\Shop\ProductResource\Pages;

use App\Filament\Resources\Shop\ProductResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getTitle(): string
    {
        return 'Товары';
    }

    protected function getDeleteBulkAction(): Tables\Actions\BulkAction
    {
        return parent::getDeleteBulkAction()
            ->action(fn () => $this->notify(
                'warning',
                'Now, now, don’t be cheeky, leave some records for others to play with!',
            ));
    }

    protected function getHeaderWidgets(): array
    {
        return [];
//        return ProductResource::getWidgets();
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [25, 50, 100];
    }
}
