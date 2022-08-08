<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\ProductResource\Pages;
use App\Filament\Resources\Shop\ProductResource\RelationManagers;
use App\Filament\Resources\Shop\ProductResource\Widgets\ProductStats;
use App\Models\Shop\Category;
use App\Models\Shop\OrderSource;
use App\Models\Shop\Product;
use App\Services\CacheService;
use App\Services\Helpers\ModelHelper;
use Exception;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $slug = 'products';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Товары';

    protected static ?string $pluralLabel = 'Товары';

    protected static ?string $modelLabel = 'Товар';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getFormSchema(Forms\Components\Card::class))
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::getTableColumns())
            ->actions([])
            ->filters([
                //TODO
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrderRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ProductStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'sku', 'barcode', 'product_id'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'ID'  => $record->product_id,
            'Стоимость' => $record->price,
            'Sku' => $record->sku,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('shop_id', CacheService::getAccountId());
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return self::getEloquentQuery()->where('shop_id', CacheService::getAccountId());
    }

    /**
     * @throws Exception
     */
    public static function getFormSchema(string $layout = Forms\Components\Grid::class): array
    {
        return [
            Forms\Components\Group::make()
                ->schema([
                    $layout::make()
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Название')
                                ->required(),

                            //TODO fatal
                            Forms\Components\Select::make('categories.name')
                                ->label('Категория')
                                ->relationship('categories', 'name')
                                ->searchable()
                                ->getSearchResultsUsing(function (string $query) {

//                                    dd($query);
                                    return Category::query()
                                        ->where('shop_id', CacheService::getAccountId())
                                        ->where('name', 'like', "%{$query}%")
                                        ->pluck('name', 'id')
                                        ->toArray();
                                })
                                ->getOptionLabelUsing(fn ($value): ?string => Category::query()->find($value)?->name)
                                ->required(),

                            Forms\Components\MarkdownEditor::make('description')
                                ->label('Описание')
                                ->columnSpan([
                                    'sm' => 2,
                                ]),
                        ])->columns([
                            'sm' => 2,
                        ]),
                    $layout::make()
                        ->schema([
                            Forms\Components\Placeholder::make('Стоимость'),
                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\TextInput::make('price')
                                        ->numeric()
                                        ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                        ->label('Цена продажи')
                                        ->required(),
                                    Forms\Components\TextInput::make('cost')
                                        ->label('Закупочная цена')
                                        ->numeric()
                                        ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                        ->required(),
                                    Forms\Components\TextInput::make('old_price')
                                        ->numeric()
                                        ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                        ->label('Старая цена')
                                        ->disabled(),
                                ]),
                        ]),
                    $layout::make()
                        ->schema([
                            Forms\Components\Placeholder::make('Учет'),
                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\TextInput::make('sku')
                                        ->label('Артикул')
                                        ->unique(Product::class, 'sku', fn ($record) => $record)
                                        ->required(),
                                    Forms\Components\TextInput::make('barcode')
                                        ->label('Штрихкод')
                                        ->unique(Product::class, 'barcode', fn ($record) => $record)
                                        ->required(),
                                    Forms\Components\TextInput::make('qty')
                                        ->label('Количество')
                                        ->numeric()
                                        ->rules(['integer', 'min:0'])
                                        ->required(),
                                    Forms\Components\Select::make('weight_unit')//TODO справочник
                                        ->label('Единица измерения')
                                        ->options([
                                            'кг' => 'кг',
                                            'шт' => 'шт',
                                        ])
                                        ->required(),
                                    Forms\Components\TextInput::make('security_stock')
                                        ->label('Неснижаемый остаток')
                                        ->helperText('Количество товара, при котором вы будете оповещены')
                                        ->numeric()
                                        ->rules(['integer', 'min:0'])
                                        ->required(),

                                    Forms\Components\Hidden::make('shop_id')
                                        ->default(CacheService::getAccountId())
                                ]),
                        ]),

                ])->columnSpan([
                    'sm' => 2,
                ]),
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('product_id')
                        ->label('ID')
                        ->default(
                            ModelHelper::generateId(self::$model, 'product_id'))
                        ->disabled(),

                    Forms\Components\Placeholder::make('created_at')
                        ->label('Создан')
                        ->content(fn (?Product $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Обновлен')
                        ->content(fn (?Product $record): string => $record ? $record->updated_at->diffForHumans() : '-'),

                    Forms\Components\FileUpload::make('image')
                        ->label('Картинка')
                        ->image(),
                ])
                ->columnSpan(1),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('product_id')
                ->label('ID')
                ->toggleable()
                ->toggledHiddenByDefault()
                ->searchable()
                ->sortable(),
//            Tables\Columns\SpatieMediaLibraryImageColumn::make('product-image')
//                ->label('Картинка')
//                ->collection('product-images'),
            Tables\Columns\TextColumn::make('name')
                ->label('Название')
                ->searchable(),
            Tables\Columns\TextColumn::make('price')
                ->label('Цена')
                ->sortable(),
            Tables\Columns\TextColumn::make('sku')
                ->searchable()
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('qty')
                ->label('Остаток')
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('description')
                ->label('Описание')
                ->toggleable()
                ->getStateUsing(fn ($record): ?string => mb_strimwidth($record->description, 0, 50, "...")),
            Tables\Columns\TextColumn::make('security_stock')
                ->label('Защищенный остаток')
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault(true),
        ];
    }

//    protected static function getNavigationBadge(): ?string
//    {
//        return self::$model::whereColumn('qty', '<', 'security_stock')->count();
//    }
}
