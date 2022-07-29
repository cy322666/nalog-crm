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
use Illuminate\Support\Facades\Request;

class StockSecondList extends BaseWidget
{
    protected function getTableHeading(): string|Closure|null
    {
        return 'Подсклады';
    }

    protected static ?int $sort = 2;


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

    protected function getTableQuery() : Builder
    {
        $query = Stock::query()->where('shop_id', CacheService::getAccountId());

        $stockQuery = Request::query('stock');
        $isChildren = Request::query('children');

        if ($stockQuery) {

            if ($isChildren) {

                $query = $query->where('parent_stock_id', '>', 0);
            } else
                $query = $query
                    ->where('stock_id', $stockQuery)
                    ->first()
                        ->children()
                        ->getQuery();
        } else
            $query = $query->where('parent_stock_id', '>', 0);

        return $query;
    }

    /**
     * @throws Exception
     */
    protected function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make(),
        ];
    }

    public function mountTableAction(string $name, ?string $record = null)
    {
        $this->redirect(StockResource::getUrl($name, ['record' => $record]));
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('stock_id')
                ->label('ID')
                ->searchable(),
            Tables\Columns\TextColumn::make('name')
                ->label('Название')
                ->url(fn ($record) => StockResource::getUrl('index', [
                    'stock'    => $record->stock_id,
                    'children' => 1,
                ]))
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Дата создания')
                ->date()
                ->sortable(),
        ];
    }
}
