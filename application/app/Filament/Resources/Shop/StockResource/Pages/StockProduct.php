<?php

namespace App\Filament\Resources\Shop\StockResource\Pages;

use App\Filament\Resources\Shop\StockResource;
use App\Filament\Widgets\StockList;
use App\Filament\Widgets\StockListProducts;
use Filament\Resources\Pages\Page;

class StockProduct extends Page
{
    protected static string $resource = StockResource::class;

    protected static string $view = 'filament.resources.stock-resource.pages.stock-product';

    protected function getHeaderWidgets(): array
    {
        return [
            StockList::class,
            StockList::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            StockListProducts::class,
        ];
    }
}
