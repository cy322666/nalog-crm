<?php

namespace App\Filament\Resources\Shop\ShopResource\Pages;

use App\Filament\Resources\Shop\ShopResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListShops extends ListRecords
{
    protected null|string $maxContentWidth = '5xl';

    protected static string $resource = ShopResource::class;

    protected function getTitle(): string
    {
        return 'Аккаунты';
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

    public function isTableSearchable(): bool
    {
        return false;
    }
}
