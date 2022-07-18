<?php

namespace App\Filament\Resources\Shop\CategoryResource\RelationManagers;

use App\Filament\Resources\Shop\ProductResource;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\AttachAction;

class ProductsRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $pluralLabel = 'Товары';

    protected static ?string $modelLabel = 'Товар';

    protected static ?string $label = 'asssss';

    protected static ?string $recordTitleAttribute = 'product_id';

    public static function table(Table $table): Table
    {
        return $table
            ->columns(ProductResource::getTableColumns())
            ->filters([])
            ->actions([])
            ->headerActions([
                AttachAction::make(),
            ]);
    }
}
