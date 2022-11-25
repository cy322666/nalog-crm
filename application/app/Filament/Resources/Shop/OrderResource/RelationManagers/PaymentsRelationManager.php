<?php

namespace App\Filament\Resources\Shop\OrderResource\RelationManagers;

use App\Filament\Resources\PaymentResource;
use App\Models\Shop\Payment;
use App\Models\Shop\PaymentMethod;
use App\Models\Shop\PaymentProvider;
use App\Models\Shop\PaymentStatus;
use App\Services\CacheService;
use App\Services\Helpers\ModelHelper;
use Exception;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Auth;

class PaymentsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $label = 'Платеж';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Платежи';

    /**
     * @throws Exception
     */
    public static function form(Form $form): Form
    {
        $methods   = PaymentMethod::all()->pluck('name', 'id');
        $providers = PaymentProvider::all()->pluck('name', 'id');
        $statuses  = PaymentStatus::all()->pluck('name', 'id');

        return $form->schema([
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->default('Платеж #'.ModelHelper::generateId(Payment::class, 'payment_id'))
                        ->label('Название'),
                    Forms\Components\Select::make('status_id')
                        ->label('Статус')
                        ->options($statuses),
                    Forms\Components\TextInput::make('amount')
                        ->hint('Pубли')
                        ->label('Сумма')
                        ->required()
                        ->columnSpan(1),
                ])
                ->columns([
                    'sm' => 1
                ])
                ->columnSpan([
                    'sm' => 1
                ]),
              Forms\Components\Card::make()
                  ->schema([
                      Forms\Components\Select::make('method_id')
                          ->label('Способ оплаты')
                          ->required()
                          ->options($methods),
//                      Forms\Components\Select::make('provider_id')
//                          ->label('Платежная система')
//                          ->required()
//                          ->options($providers),

                      Forms\Components\Hidden::make('shop_id')
                            ->default(CacheService::getAccount()->id),

                      Forms\Components\Hidden::make('creator_id')
                          ->default(Auth::user()->id),
                  ])
                  ->columns([
                      'sm' => 1
                  ])
                  ->columnSpan([
                      'sm' => 1
                  ]),
        ])->columns(2);
    }

    /**
     * @throws Exception
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        PaymentResource::createActions($data);

        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment.name')
                    ->label('ID')
                    ->toggleable()
                    ->toggledHiddenByDefault(true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Название'),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Сумма')
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

//                Tables\Columns\TextColumn::make('provider.name')
//                    ->label('Платежная система')
//                    ->sortable(),

                Tables\Columns\TextColumn::make('method.name')
                    ->label('Способ оплаты')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }
}
