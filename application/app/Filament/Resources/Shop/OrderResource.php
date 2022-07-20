<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Forms\Components\AddressForm;
use App\Filament\Resources\Shop\OrderResource\Pages;
use App\Filament\Resources\Shop\OrderResource\RelationManagers;
use App\Filament\Resources\Shop\OrderResource\Widgets\OrderStats;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\OrderSources;
use App\Models\Shop\OrderStatus;
use App\Models\Shop\Product;
use App\Models\Shop\Shop;
use App\Services\CacheService;
use Carbon\Carbon;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Squire\Models\Currency;//TODO заменить на мой

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $slug = 'shop/orders';

    protected static ?string $recordTitleAttribute = 'number';

    protected static ?string $navigationLabel = 'Заказы';

    protected static ?string $pluralLabel = 'Заказы';

    protected static ?string $modelLabel = 'Заказ';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?int $navigationSort = 2;

    public $shop;//TODO заменить билдеры на отношения

    public function __construct()
    {
        $this->shop = Shop::query()->find(CacheService::getAccountId());
    }

    public static function getEloquentQuery(): Builder
    {
        return Order::query()->where('shop_id', CacheService::getAccountId());
    }

    private static function getHistory()
    {
        $comments = [
            [
                'label'   => 'чето там',
                'content' => 'контент',
            ],
            [
                'label'   => 'чето там',
                'content' => 'контент',
            ],
            [
                'label'   => 'чето там',
                'content' => 'контент',
            ],
            [
                'label'   => 'чето там',
                'content' => 'контент',
            ],
            [
                'label'   => 'чето там',
                'content' => 'контент',
            ],
        ];

//        $components = [];
//
//        foreach ($comments as $comment) {
//
//            $components[] = Forms\Components\Placeholder::make('')
//                ->label($comment['label'])
//                ->content(fn (?Order $record): string => $comment['content']);
//        }

//        return $components;
    }

//    protected function getFormModel(): Order
//    {
//        return $this->order;
//    }


//история
//Forms\Components\Group::make()
//->schema([
//Forms\Components\Card::make()
//->schema(self::getHistory())
//->columnSpan(1),
//
//Forms\Components\Textarea::make('')
//->columnSpan(1)
//->reactive()
//
//])
//->columns(1),
    /**
     * @throws Exception
     */
    public static function form(Form $form): Form
    {
        //TODO услуги
        return $form
            ->schema([
                Tabs::make('')
                    ->tabs([
                        Tabs\Tab::make('Общие')
                            ->schema([
                                //основная форма
                                //TODO title?

                                Forms\Components\Card::make()
                                    ->schema([

                                        Forms\Components\TextInput::make('number')
                                            ->label('Название')
                                            ->columnSpan(1),

                                        Forms\Components\Select::make('status')
                                            ->label('Статус')
                                            ->options(
                                                OrderStatus::query()
                                                    ->where('shop_id', CacheService::getAccountId())
                                                    ->orWhere('shop_id', 0)
                                                    ->pluck('name', 'status_id')
                                                    ->toArray()
                                            )
                                            ->default(101),

                                        Forms\Components\TextInput::make('total_price')
                                            ->hint('Pубли')
                                            ->label('Бюджет')
                                            ->columnSpan(1),

                                        Forms\Components\Select::make('source')
                                            ->label('Источник')
                                            ->options(
                                                OrderSources::query()
                                                    ->where('shop_id', CacheService::getAccountId())
                                                    ->orWhere('shop_id', 0)
                                                    ->pluck('name', 'source_id')
                                                    ->toArray())
                                            ->required(),

                                        //TODO обязательность при закрытии как то сделать
//                                        Forms\Components\Select::make('reasons')
//                                            ->label('Причина отказа')
//                                            ->options(
//                                                Shop::query()->find(CacheService::getAccountId())->reasons->toArray()
//                                            )
//                                            ->required()
//                                            ->reactive(),

                                        //нижняя часть основной
                                        //TODO сделать тут custom поля
//                                        AddressForm::make('address')->columnSpan([
//                                            'sm' => 2,
//                                        ]),

                                    ])->columns([
                                        'sm' => 2,
                                    ]),
                                ]),
                        Tabs\Tab::make('Товары')
                            ->schema([
                                //форма с товарами
                                Forms\Components\Card::make()
                                    ->schema([
                                        Forms\Components\Repeater::make('items')
                                            ->relationship()
                                            ->schema([
                                                Forms\Components\Select::make('shop_product_id')
                                                    ->label('Product')
                                                    ->options(//TODO поиск
                                                        Product::query()->pluck('name', 'id'))
                                                    ->required()
                                                    ->reactive()
                                                    ->afterStateUpdated(function ($state, callable $set) {

                                                        return $set('unit_price', Product::find($state)?->price ?? 0);
                                                    })
                                                    ->columnSpan([
                                                        'md' => 5,
                                                    ]),
                                                Forms\Components\TextInput::make('qty')
                                                    ->numeric()
                                                    ->mask(
                                                        fn (Forms\Components\TextInput\Mask $mask) => $mask
                                                            ->numeric()
                                                            ->integer()
                                                    )
                                                    ->default(1)
                                                    ->columnSpan([
                                                        'md' => 2,
                                                    ])
                                                    ->required(),
                                                Forms\Components\TextInput::make('unit_price')
                                                    ->label('Unit Price')
                                                    ->disabled()
                                                    ->numeric()
                                                    ->required()
                                                    ->columnSpan([
                                                        'md' => 3,
                                                    ]),
                                            ])
                                            ->dehydrated()
                                            ->orderable()
                                            ->defaultItems(1)
                                            ->disableLabel()
                                            ->columns([
                                                'md' => 10,
                                            ])
                                            ->required(),
                                    ]),//TODO рассчитать сумму
                                ]),

                        Tabs\Tab::make('Услуги')
                            ->schema([


                            ]),
                    ])->columnSpan([
                        'sm' => 2,
                    ]),

                Forms\Components\Group::make([
                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\TextInput::make('number')
                                ->label('Номер заказа')
                                ->default(
                                    ++Order::query()
                                        ->where('shop_id', CacheService::getAccountId())
                                        ->latest('id')//TODO order_id
                                        ->first()
                                        ->id)
                                ->disabled(),
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Создан')
                                ->content(fn (?Order $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Последнее изменение')
                                ->content(fn (?Order $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                            Forms\Components\Placeholder::make('')
                                ->label('Дней в работе')
                                ->content(fn (?Order $record): string => $record ? (Carbon::now())->diffInDays() : 0)
                        ])
                        ->columnSpan(1),

                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\Select::make('shop_customer_id')
                                ->label('Клиент')
                                ->relationship('customer', 'name')
                                ->searchable()
                                ->getSearchResultsUsing(function (string $query) {

                                    return Customer::query()
                                        ->where('shop_id', CacheService::getAccountId())
                                        ->where('name', 'like', "%{$query}%")
                                        ->pluck('name', 'id')
                                        ->toArray();
                                })
                                ->getOptionLabelUsing(fn ($value): ?string => Customer::query()->find($value)?->name)
                                ->required(),
                            //TODO краткая инфа клиента и конечно же его тип!
                        ])
                        ->columnSpan(1),
                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\Select::make('shop_customer_id')
                                ->label('Задача'),
//                                ->relationship('customer', 'name')
//                                ->searchable()
//                                ->getSearchResultsUsing(function (string $query) {
//
//                                    return Customer::query()
//                                        ->where('shop_id', CacheService::getAccountId())
//                                        ->where('name', 'like', "%{$query}%")
//                                        ->pluck('name', 'id')
//                                        ->toArray();
//                                })
//                                ->getOptionLabelUsing(fn ($value): ?string => Customer::query()->find($value)?->name)
//                                ->required(),
                        ])
                        ->columnSpan(1),
                ]),
            ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Клиент')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
//TODO customer.type
//TODO link statuses
                Tables\Columns\BadgeColumn::make('status.name')
                    ->label('Статус')
                    ->colors(
                        Shop::query()->find(CacheService::getAccountId())
                            ->statuses
                            ->pluck('type', 'name')
                            ->toArray()

//                        [
//                        'danger'  => 'cancelled',
//                        'warning' => 'processing',
//                        'success' => fn ($state) => in_array($state, ['delivered', 'shipped']),
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Цена')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipping_price')
                    ->label('Цена закупки')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->date()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
                        Forms\Components\DatePicker::make('created_until')
                            ->placeholder(fn ($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([])
            ->bulkActions([
                //TODO
            ]);
    }

    //ширин
//    protected function getTableFiltersFormWidth(): string
//    {
//        return '4xl';
//    }
    //столбцов в фильтрах
    protected function getTableFiltersFormColumns(): int
    {
        return 3;
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            OrderStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'   => Pages\ListOrders::route('/'),
            'view'    => Pages\ViewOrder::route('/{record}'),
            'settings'=> Pages\ListSettingOrder::route('/settings'),
            'create'  => Pages\CreateOrder::route('/create'),
            'edit'    => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['number'];//, 'customer.name'
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Customer' => optional($record->customer)->name,
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['customer', 'items']);
    }
}
