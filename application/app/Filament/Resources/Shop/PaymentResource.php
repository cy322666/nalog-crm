<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\PaymentResource\Pages;
use App\Filament\Resources\Shop\PaymentResource\RelationManagers;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\Payment;
use App\Models\Shop\PaymentMethod;
use App\Models\Shop\PaymentProvider;
use App\Models\Shop\PaymentStatus;
use App\Services\CacheService;
use App\Services\Helpers\ModelHelper;
use Carbon\Carbon;
use Exception;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $slug = 'payments';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Платежи';

    protected static ?string $pluralLabel = 'Платежи';

    protected static ?string $modelLabel = 'Платеж';

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->where('shop_id', CacheService::getAccountId());
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('shop_id', CacheService::getAccountId());
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Заказ' => optional($record->order)->name,
            'Сумма' => $record->amount,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'order.name'];
    }

    /**
     * @throws Exception
     */
    public static function form(Form $form): Form
    {
        $name = 'Платеж #'.ModelHelper::generateId(Payment::class, 'payment_id');

        $methods   = PaymentMethod::all()->pluck('name', 'id');
        $providers = PaymentProvider::all()->pluck('name', 'id');
        $statuses  = PaymentStatus::all()->pluck('name', 'id');

        return $form->schema([
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->placeholder($name)
                        ->label('Название')
                        ->default(
                            'Платеж #'.ModelHelper::generateId(Payment::class, 'payment_id')
                        ),
                    Forms\Components\Select::make('status_id')
                        ->label('Статус')
                        ->options($statuses),
                    Forms\Components\TextInput::make('amount')
                        ->hint('Pубли')
                        ->label('Сумма')
                        ->required()
                        ->columnSpan(1),
                    Forms\Components\Select::make('method_id')
                        ->label('Способ оплаты')
                        ->required()
                        ->options($methods),
                    Forms\Components\Select::make('provider_id')
                        ->label('Платежная система')
                        ->required()
                        ->options($providers),

                    Forms\Components\Select::make('order_id')
                        ->label('Заказ')
                        ->relationship('order', 'name')
                        ->searchable()
                        ->getOptionLabelUsing(fn ($value): ?string => Order::query()->find($value)?->name)
                        ->required(),

                    Forms\Components\Hidden::make('shop_id')
                        ->default(CacheService::getAccountId()),

                    Forms\Components\Hidden::make('creator_id')
                        ->default(Auth::user()->id),
            ])->columns([
                'sm' => 2
                ])
            ->columnSpan([
                'sm' => 2
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
                            ->label('Последнее изменение')
                            ->content(fn (?Payment $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                        Forms\Components\Placeholder::make('')
                            ->label('Дней в работе')
                            ->content(fn (?Payment $record): string => $record ? (Carbon::now())->diffInDays() : 0)
                    ])
                    ->columnSpan(1),
                ]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment_id')
                    ->label('ID')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Сумма')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status.name')
                    ->label('Статус')
                    ->colors([
                        'primary' => fn ($state): bool => true,
                        'danger'  => fn ($state): bool => $state === PaymentStatus::LOST_STATUS_NAME,
                        'warning' => fn ($state): bool => $state === PaymentStatus::NEW_STATUS_NAME,
                        'success' => fn ($state): bool => $state === PaymentStatus::WIN_STATUS_NAME,
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('order.name')
                    ->label('Заказ')
                    ->url(fn ($record) => OrderResource::getUrl('edit', [$record->order]))//TODO view?
                    ->searchable(),

                Tables\Columns\TextColumn::make('provider.name')
                    ->label('Платежная система')
                    ->sortable(),

                Tables\Columns\TextColumn::make('method.name')
                    ->label('Способ оплаты')
                    ->sortable(),
//TODO дата оплаты добавить

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime()
                    ->toggleable(true)
                    ->sortable(),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function createActions(array &$data)
    {
        $data['payment_id'] = ModelHelper::generateId(Payment::class, 'payment_id');

        if (empty($data['name'])) {

            $data['name'] = 'Платеж #'.$data['payment_id'];
        }
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit'   => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
