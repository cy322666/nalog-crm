<?php

namespace App\Filament\Resources\Shop\StockResource\Pages;

use App\Filament\Resources\Shop\StockResource;
use App\Filament\Widgets\StockList;
use App\Filament\Widgets\StockListProducts;
use App\Filament\Widgets\StockSecondList;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\Page;

class StockProduct extends Page
{
    protected static string $resource = StockResource::class;

    protected static string $view = 'filament.resources.stock-resource.pages.stock-product';

    protected function getTitle(): string
    {
        return 'Склады';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StockList::class,
            StockSecondList::class,
        ];
    }

    protected function getActions(): array
    {
        return [
            Action::make('create')
                ->label('Создать')
                ->url(StockResource::getUrl('create')),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            StockListProducts::class,
        ];
    }
}
