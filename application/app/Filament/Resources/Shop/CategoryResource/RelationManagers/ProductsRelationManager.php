<?php

namespace App\Filament\Resources\Shop\CategoryResource\RelationManagers;

use App\Filament\Resources\Shop\ProductResource;
use App\Services\CacheService;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\AttachAction;
use Illuminate\Database\Eloquent\Builder;

class ProductsRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $pluralLabel = 'Товары';

    protected static ?string $modelLabel = 'Товар';

    protected static ?string $label = 'asssss';

    protected static ?string $recordTitleAttribute = 'name';

    protected function applySearchToTableQuery(Builder $query): Builder
    {
        return  $query->where('shop_id', CacheService::getAccount()->id);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(ProductResource::getTableColumns())
            ->filters([])
            ->actions([])
            ->headerActions([
                AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),//TODO поиск по филиалу ток
                ])
            ]);
    }
}
