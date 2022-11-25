<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Shop\StockResource;
use App\Models\Shop\Stock;
use App\Services\CacheService;
use Closure;
use Exception;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class StockList extends BaseWidget
{
    protected function getTableHeading(): string|Closure|null
    {
        return 'Склады';
    }

    protected static ?int $sort = 2;


//    public function getDefaultTableRecordsPerPageSelectOption(): int
//    {
//        return 5;
//    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
//
//    public function isTableSearchable(): bool
//    {
//        return false;
//    }

    protected function getTableQuery(): Builder
    {
        return Stock::query()->where('shop_id', CacheService::getAccount()->id);
    }

    public function mountTableAction(string $name, ?string $record = null)
    {
       $this->redirect(StockResource::getUrl($name, ['record' => $record]));
    }

    /**
     * @throws Exception
     */
    protected function getTableActions(): array
    {
        return [
//            Tables\Actions\EditAction::make(),
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('stock_id')
                ->label('ID')
                ->searchable(),
            Tables\Columns\TextColumn::make('name')
                ->label('Название')
                ->url(fn ($record) => StockResource::getUrl('edit', ['record' => $record->stock_id]))
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Дата создания')
                ->date()
                ->sortable(),
        ];
    }
}
