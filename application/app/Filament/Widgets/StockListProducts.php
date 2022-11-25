<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Shop\ProductResource;
use App\Models\Shop\Product;
use App\Models\Shop\Stock;
use App\Services\CacheService;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class StockListProducts extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected function getTableHeading(): string|null
    {
        return 'Остатки склада';
    }

    public function isTableSearchable(): bool
    {
        return true;
    }

    protected function getTableQuery(): Builder
    {
        return CacheService::getAccount()->stocks
            ->first()
            ->products()
            ->getQuery();
    }

    protected function getTableActions(): array
    {
        return [];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [15, 30, 50];
    }

    protected function getTableColumns(): array
    {
        //TODO защищенный остаток
        return [
            Tables\Columns\SpatieMediaLibraryImageColumn::make('product-image')
                ->label('Картинка')
                ->collection('product-images')
                ->hidden(true),
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
            Tables\Columns\TextColumn::make('qty')
                ->label('Остаток')
                ->sortable(),
        ];
    }
}
