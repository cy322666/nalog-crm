<?php

namespace App\Filament\Widgets;

use App\Models\Shop\Shop;
use App\Services\CacheService;
use App\Tables\Columns\ButtonSettingsColumn;
use Filament\Pages\Actions\CreateAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

class ListShopsWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

//    protected ?string $maxContentWidth = '7xl';

    public function getTableHeading(): string
    {
        return '';
    }

    protected function getTableQuery() : \Illuminate\Database\Eloquent\Builder
    {
        return Shop::query()
            ->where('user_id', CacheService::getAccountId())
            ->orderBy('active');
    }

    public function click()
    {
        dd('asd');
    }

    protected function getTableColumns(): array
    {
        return [

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
