<?php

namespace App\Filament\Widgets;

use App\Models\Shop\Stock;
use App\Services\CacheService;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;

class StockListProducts extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

      //TODO dont work
    //protected int | string | array $columnSpan = '5xl';

    protected static ?int $sort = 2;

    protected function getTableHeading(): string|null
    {
        return 'Остатки склада';
    }

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 5;
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    public function isTableSearchable(): bool
    {
        return false;
    }

    protected function getTableQuery(): Builder
    {
        $stockId = Request::query('stock') ?? CacheService::getAccountId();

        return Stock::query()->where('stock_id', $stockId)->first()->products()->getQuery();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('stock_id')
                ->label('ID')
                ->searchable(),
            Tables\Columns\TextColumn::make('name')
                ->label('Name')
                ->searchable()
                ->sortable(),
            //TODO count
            Tables\Columns\TextColumn::make('description')
                ->label('Описание')
                ->getStateUsing(fn ($record): ?string => mb_strimwidth($record->description, 0, 50, "...")),
        ];
    }
}
