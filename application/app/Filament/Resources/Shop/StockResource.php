<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\StockResource\Pages;
use App\Models\Shop\Stock;
use App\Services\CacheService;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $navigationLabel = 'Склады';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        //TODO generate id
                        //TODO
//                            Forms\Components\TextInput::make('number')
//                                ->label('Номер заказа')
//                                ->default(random_int(100000, 999999))
//                                ->disabled()
//                                ->required(),
//                            Forms\Components\Select::make('shop_customer_id')

                        Forms\Components\TextInput::make('name')
                            ->label('Название')
                            ->required(),

                        Forms\Components\Select::make('parent_stock_id')
                            ->label('Основной склад')
                            ->options(
                                Stock::query()
                                    ->where('shop_id', CacheService::getAccountId())
                                    ->where('parent_stock_id', null)
                                    ->pluck('name', 'id')
                                    ->toArray()
                            )->helperText('*Выбирать при создании подсклада')
                    ])
                    ->columns(2)
                    ->columnSpan([
                        'sm' => 2,
                    ]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Создан')
                            ->content(fn (?Stock $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Последнее изменение')
                            ->content(fn (?Stock $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\StockProduct::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit'   => Pages\EditStock::route('/{record}/edit'),
        ];
    }
}
