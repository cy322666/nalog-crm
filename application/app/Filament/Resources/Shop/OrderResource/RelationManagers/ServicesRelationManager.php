<?php

namespace App\Filament\Resources\Shop\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\CreateAction;

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
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->label('Стоимость')
                    ->required()//TODO check validate
            ])
            ->columns(['md' => 1]);
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
                CreateAction::make(),
            ]);
    }
}
