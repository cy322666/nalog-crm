<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Resources\Form;
use Filament\Resources\RelationManagers\MorphToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class ContractsRelationManager extends MorphToManyRelationManager
{
    protected static string $relationship = 'contracts';

    protected static ?string $title = 'Договоры';

    protected static ?string $label = 'Договор';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
//                Tables\Columns\TextColumn::make('order_id')
//                    ->label('ID')
//                    ->toggleable()
//                    ->toggledHiddenByDefault(true)
//                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Название'),

//                Tables\Columns\BadgeColumn::make('status.name')
//                    ->label('Статус')
//                    ->colors([
//                        'primary' => fn ($state): bool => true,
//                        'danger'  => fn ($state): bool => $state === OrderStatus::LOST_STATUS_NAME,
//                        'warning' => fn ($state): bool => $state === OrderStatus::NEW_STATUS_NAME,
//                        'success' => fn ($state): bool => $state === OrderStatus::WIN_STATUS_NAME,
//                    ])
//                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Бюджет')
                    ->sortable(),

                Tables\Columns\TextColumn::make('responsible.name')
                    ->label('Ответственный')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлен')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(true),
            ])
            ->filters([])
            ->actions([])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make(),
            ]);
    }
}
