<?php

namespace App\Filament\Resources\Shop\ShopResource\Pages;

use App\Filament\Resources\Shop\ShopResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Phpsa\FilamentFeed\Widgets\FeedWidget;

class ListShops extends ListRecords
{
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

    protected function getFooterWidgets() : array
    {
        return [];
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
