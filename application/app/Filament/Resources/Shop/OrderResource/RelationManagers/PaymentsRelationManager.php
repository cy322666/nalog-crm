<?php

namespace App\Filament\Resources\Shop\OrderResource\RelationManagers;

use Akaunting\Money\Currency;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class PaymentsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Платежи';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

//                Forms\Components\TextInput::make('amount')
//                    ->numeric()
//                    ->required(),
//
//                Forms\Components\Select::make('currency')
//                    ->options(collect(Currency::getCurrencies())->mapWithKeys(fn ($item, $key) => [$key => data_get($item, 'name')]))
//                    ->searchable()
//                    ->required(),
//
//                Forms\Components\Select::make('provider')
//                    ->options([
//                        'stripe' => 'Stripe',
//                        'paypal' => 'PayPal',
//                    ])
//                    ->required(),
//
//                Forms\Components\Select::make('method')
//                    ->options([
//                        'credit_card' => 'Credit card',
//                        'bank_transfer' => 'Bank transfer',
//                        'paypal' => 'PayPal',
//                    ])
//                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                    Tables\Columns\TextColumn::make('payment_id')
                        ->label('ID')
                        ->toggleable(true)
                        ->sortable()
                        ->searchable(),

                    Tables\Columns\TextColumn::make('name')
                        ->label('Название'),

                    Tables\Columns\TextColumn::make('amount')
                        ->label('Сумма')
                        ->sortable(),

                    Tables\Columns\TextColumn::make('provider')
                        ->label('Платежная система')
                        ->sortable(),

                    Tables\Columns\TextColumn::make('steps')
                        ->label('Частей')
                        ->toggleable(true)
                        ->sortable(),

                    Tables\Columns\TextColumn::make('method')
                        ->label('Способ оплаты')
                        ->sortable(),

                    Tables\Columns\BooleanColumn::make('payed')
                        ->label('Оплачен полнстью')//TODO bool
                        ->toggleable(true)
                        ->sortable(),

                    Tables\Columns\TextColumn::make('created_at')
                        ->label('Создан')
                        ->dateTime()
                        ->toggleable(true)
                        ->sortable(),
            ])
            ->filters([])
            ->actions([]);
    }
}
