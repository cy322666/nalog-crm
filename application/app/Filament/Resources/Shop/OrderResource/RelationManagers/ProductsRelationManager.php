<?php

namespace App\Filament\Resources\Shop\OrderResource\RelationManagers;

use Ably\Log;
use Akaunting\Money\Currency;
use App\Models\Shop\Customer;
use App\Models\Shop\Product;
use App\Services\CacheService;
use Exception;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Illuminate\Support\Str;

class ProductsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $title = 'Товары';

    protected static ?string $label = 'Товар';

    protected static ?string $recordTitleAttribute = 'name';

    protected bool $allowsDuplicates = true;

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_id')
                    ->label('ID')
                    ->toggleable(true)
                    ->toggledHiddenByDefault(true),

                Tables\Columns\TextColumn::make('name')
                    ->label('Название'),

                Tables\Columns\TextColumn::make('sku')
                    ->label('Артикул')
                    ->sortable(),

                Tables\Columns\TextColumn::make('unit_price')
                    ->label('Цена за единицу'),

                Tables\Columns\TextColumn::make('count')
                    ->label('Количество')
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ])
            ->headerActions([

                AttachAction::make()
                    ->label('Прикрепить')
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->afterStateUpdated(function (\Closure $set, $state) {

                                $set('unit_price', Product::query()->find($state)->first()->price);
                            })
                            ->reactive(),

                    Forms\Components\TextInput::make('count')
                        ->label('Количество')
                        ->required(),

                    Forms\Components\TextInput::make('unit_price')
                        ->reactive()
                        ->label('Цена единицы')
                        ->disabled(),
                    ])
            ]);
    }
}
