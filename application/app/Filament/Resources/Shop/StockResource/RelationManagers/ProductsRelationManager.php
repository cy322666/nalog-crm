<?php

namespace App\Filament\Resources\Shop\StockResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('sku'),
                Tables\Columns\TextColumn::make('security_stock'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('product_id'),
                //TODO количество на этом складе
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
//                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [25, 50, 100];
    }
}
