<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Models\Contract;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('conclusion_at')
                    ->label('Дата заключения')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('execution_at')
                    ->label('Дата исполнения')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('region_id')
                    ->label('Регион')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number')
                    ->label('Номер')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contract_type_id')
                    ->label('Тип договора')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('work_type')
                    ->label('Тип работ')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contract_form')
                    ->label('Форма договора')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contragent')
                    ->label('Контрагент')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('partner')
                    ->label('Партнер')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('manager.name')
                    ->label('Менеджер')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('responsible.name')
                    ->label('Ответственный')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('presale.name')
                    ->label('Пресейл')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Сумма')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payed')
                    ->label('Оплачено')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_type_id')
                    ->label('Тип оплаты')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_type_id')
                    ->label('Дата проведения повторного обследования')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_renewal')
                    ->label('Дата продления')
                    ->searchable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }    
}
