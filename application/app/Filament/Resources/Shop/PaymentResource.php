<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\PaymentResource\Pages;
use App\Filament\Resources\Shop\PaymentResource\RelationManagers;
use App\Models\Shop\Order;
use App\Models\Shop\Payment;
use App\Services\CacheService;
use App\Services\ModelHelper;
use Carbon\Carbon;
use Exception;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationLabel = 'Платежи';

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery();//->where('shop_id', CacheService::getAccountId());
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();//->where('shop_id', CacheService::getAccountId());
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
                        Forms\Components\Select::make('status.name')
                            ->label('Статус')
                            ->options([]
//                                OrderStatus::query()
//                                    ->where('shop_id', CacheService::getAccountId())
//                                    ->orWhere('shop_id', 0)
//                                    ->pluck('name', 'id')
//                                    ->toArray()
                            )
                            ->default(101),

                        Forms\Components\TextInput::make('amount')
                            ->hint('Pубли')
                            ->label('Сумма')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('amount_payed')
                            ->hint('Pубли')
                            ->label('Оплачено')
                            ->columnSpan(1),

                        Forms\Components\Checkbox::make('payed')
                            ->label('Оплачено полнстью')
                            ->default(false)
                            ->columnSpan(1),
                    ])
                    ->columns([
                        'sm' => 2,
                    ])
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                Forms\Components\Group::make([
                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\TextInput::make('payment_id')
                                ->label('ID')
                                ->default(
                                    ModelHelper::generateId(self::$model, 'payment_id')
                                )
                                ->disabled(),

                            Forms\Components\Placeholder::make('created_at')
                                ->label('Создан')
                                ->content(fn (?Payment $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Последнее обновление')
                                ->content(fn (?Payment $record): string => $record ? $record->updated_at->diffForHumans() : '-'),

                            Forms\Components\Placeholder::make('')
                                ->label('Дней в работе')
                                ->content(fn (?Payment $record): string => $record ? (Carbon::now())->diffInDays() : 0)
                        ])
                        ->columnSpan(1),
                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\Select::make('shop_order_id')
                                ->label('Заказ')
                                ->relationship('order', 'name')
                                ->searchable()
                                ->getSearchResultsUsing(function (string $query) {

                                    return Order::query()
                                        ->where('shop_id', CacheService::getAccountId())
                                        ->where('name', 'like', "%{$query}%")
                                        ->pluck('name', 'id')
                                        ->toArray();
                                })
                                ->getOptionLabelUsing(fn ($value): ?string => Order::query()->find($value)?->name)
                                ->required(),
                            //TODO краткая инфа заказа!
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
                Tables\Columns\TextColumn::make('payment_id')
                    ->label('ID')
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),

                Tables\Columns\TextColumn::make('order_id')
                    ->label('Заказ')
                    ->searchable(),

                Tables\Columns\TextColumn::make('provider')
                    ->label('Платежная система')
                    ->sortable(),

                Tables\Columns\TextColumn::make('steps')
                    ->label('Частей')
                    ->toggleable(true)
                    ->sortable(),

//                Tables\Columns\TextColumn::make('method')
//                    ->label('Способ оплаты')
//                    ->sortable(),

                Tables\Columns\TextColumn::make('payed')
                    ->label('Оплачен полнстью')//TODO bool
                    ->sortable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Сумма')
                    ->searchable()
                    ->sortable(),

//                Tables\Columns\TextColumn::make('currency')
//                    ->label('Валюта')
//                    ->searchable()
//                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
