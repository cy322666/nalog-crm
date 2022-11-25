<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\StockResource\Pages;
use App\Filament\Resources\Shop\StockResource\RelationManagers\ProductsRelationManager;
use App\Models\Shop\Stock;
use App\Services\CacheService;
use App\Services\Helpers\ModelHelper;
use Exception;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $slug = 'stocks';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Склады';

    protected static ?string $pluralLabel = 'Склады';

    protected static ?string $modelLabel = 'Склад';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('shop_id', CacheService::getAccount()->id);
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'ID'      => $record->stock_id,
            'Остатки' => optional($record->products)->count() ?? 0,
            'Тип'     => $record->isChild() === true ? 'Подсклад' : 'Склад',
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'stock_id'];
    }

    /**
     * @throws Exception
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Название')
                            ->required(),

                        Forms\Components\Select::make('parent_stock_id')
                            ->label('Основной склад')
                            ->options(
                                Stock::query()
                                    ->where('shop_id', CacheService::getAccount()->id)
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
                        Forms\Components\TextInput::make('stock_id')
                            ->label('ID')
                            ->default(
                                ModelHelper::generateId(self::$model, 'stock_id'))
                            ->disabled(),
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
//TODO релейшен к остаткам
//TODO а потом и поставщикам
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('stock_id')
                    ->label('ID'),
                TextColumn::make('name')
                    ->label('Название'),
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->date()
                    ->sortable(),
                TextColumn::make('parent_stock_id')
                    ->label('Тип')
                    ->getStateUsing(fn(Stock $stock): string => $stock->parent_stock_id == null ? 'Основной' : 'Подсклад'),
                TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Остаток товаров')
                    ->sortable(),
                //TODO не показывает подсклад
            ])->headerActions([
//                CreateAction::make()
            ])
            ->filters([])
            ->actions([
                //TODO пополнение
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListStock::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit'   => Pages\EditStock::route('/{record}/edit'),
        ];
    }
}
