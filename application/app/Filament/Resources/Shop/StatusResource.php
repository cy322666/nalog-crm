<?php

namespace App\Filament\Resources\Shop;

use App\Models\Shop\OrderStatus;
use App\Services\CacheService;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StatusResource extends Resource
{
    //TODO перенести в настройки orders
    protected static ?string $model = OrderStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';

    public static function getEloquentQuery(): Builder
    {
        return OrderStatus::query()
            ->where('shop_id', CacheService::getAccount()->id)
            ->orWhere('shop_id', 0);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Repeater::make('Статусы')
                            ->schema([
                                Forms\Components\Select::make('shop_product_id')
                                    ->label('Product')
                                    ->options(OrderStatus::query()->pluck('name', 'id'))
                                    ->required()
                                    ->reactive()
//                                    ->afterStateUpdated(fn ($state, callable $set) => $set('unit_price', Product::find($state)?->price ?? 0))
                                    ->columnSpan([
                                        'md' => 5,
                                    ]),
                                Forms\Components\Checkbox::make('is_system')
                                    ->columnSpan([
                                        'md' => 2,
                                    ])
                                    ->required(),
                            ])
                            ->dehydrated()
                            ->orderable()
                            ->grid(1)
                            ->collapsible()
                            ->defaultItems(1)
                            ->disableLabel()
                            ->columns([
                                'md' => 10,
                            ])
                            ->required(),
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
            ->columns(static::getTableColumns())
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //TODO task with entities
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => StatusResource\ListStatuses::route('/'),
            'view' => StatusResource\ViewStatuses::route('/change'),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\BadgeColumn::make('name')
                ->label('Название')
                ->colors([
                    'warning' => fn ($state): bool => $state === 'Новый заказ',
                    'danger'  => fn ($state): bool => $state === 'Потерян',
                    'success' => fn ($state): bool => $state === 'Успех',
                ])
                ->sortable(),

            Tables\Columns\TextColumn::make('status_id')
                ->label('ID')
                ->sortable()
        ];
    }
}
