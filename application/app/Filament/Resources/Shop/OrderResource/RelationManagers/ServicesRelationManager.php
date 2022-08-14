<?php

namespace App\Filament\Resources\Shop\OrderResource\RelationManagers;

use Akaunting\Money\Currency;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Illuminate\Support\Str;

class ServicesRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'services';

    protected static ?string $title = 'Услуги';

    protected static ?string $label = 'Услугу';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('reference')
                    ->columnSpan(2)
                    ->required(),

                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required(),

                Forms\Components\Select::make('provider')
                    ->options([
                        'stripe' => 'Stripe',
                        'paypal' => 'PayPal',
                    ])
                    ->required(),

                Forms\Components\Select::make('method')
                    ->options([
                        'credit_card' => 'Credit card',
                        'bank_transfer' => 'Bank transfer',
                        'paypal' => 'PayPal',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service_id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Название'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Стоимость')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([])
            ->headerActions([
                AttachAction::make(),
            ]);
    }
}
