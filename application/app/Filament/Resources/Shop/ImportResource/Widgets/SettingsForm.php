<?php

namespace App\Filament\Resources\Shop\ImportResource\Widgets;

use App\Filament\Resources\Shop\ShopResource\Widgets\ShopSettings;
use App\Filament\Resources\Shop\StockResource;
use App\Imports\CustomersImport;
use App\Models\Shop\Import;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class SettingsForm extends BaseWidget
{
    use InteractsWithForms;

    public ?Import $record = null;

    protected function getTableHeading(): string|null
    {
        return 'Предпросмотр соотношения';
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Relations\Relation|Builder
    {
        return $this->record->settings()->getQuery();
    }

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 30;
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    public function isTableSearchable(): bool
    {
        return false;
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('column')
                ->label('Столбец'),
            TextColumn::make('key')
                ->label('Значение'),
            TextColumn::make('entity_type')
                ->label('Объект'),
        ];
    }
}
