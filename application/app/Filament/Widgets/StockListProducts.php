<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Shop\ProductResource;
use App\Models\Shop\Stock;
use App\Services\CacheService;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;

class StockListProducts extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected function getTableHeading(): string|null
    {
        return 'Остатки склада';
    }

//    public function getDefaultTableRecordsPerPageSelectOption(): int
//    {
//        return 5;
//    }

    public function isTableSearchable(): bool
    {
        return true;
    }

    protected function getTableQuery(): Builder
    {
        $query = Stock::query()->where('shop_id', CacheService::getAccountId());

        $stockQuery = Request::query('stock');

        if ($stockQuery) {

            $query->where('stock_id',  $stockQuery);
        }

        return $query->first()->products()->getQuery();
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [15, 30, 50, 100];
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\SpatieMediaLibraryImageColumn::make('product-image')
                ->label('Картинка')
                ->collection('product-images'),
            Tables\Columns\TextColumn::make('name')
                ->label('Название')
                ->searchable(),
            Tables\Columns\TextColumn::make('price')
                ->label('Цена')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('description')
                ->label('Описание')
                ->searchable()
                ->toggleable()
                ->getStateUsing(fn ($record): ?string => mb_strimwidth($record->description, 0, 50, "...")),
            Tables\Columns\TextColumn::make('count')
                ->label('Остаток')
                ->sortable(),
        ];
    }
}