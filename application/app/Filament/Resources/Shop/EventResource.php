<?php

namespace App\Filament\Resources\Shop;

//use App\Filament\Resources\EventResource\Pages;
//use App\Filament\Resources\EventResource\RelationManagers;
use App\Filament\Resources\Shop;
use App\Models\Shop\Event;
use App\Services\CacheService;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return Event::query()
            ->where('shop_id', CacheService::getAccountId())
            ->orderByDesc('created_at');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model')
                    ->label('Объект')
                    ->getStateUsing(fn ($record): ?string => (new ($record->model))::$entity)
                    ->url(fn ($record) => $record->link)
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable(),
//                Tables\Columns\TextColumn::make('model_id')
//                    ->label('ID сущности')
//                    ->toggleable(),
                Tables\Columns\TextColumn::make('text')
                    ->label('Событие')
                    ->sortable(),
                Tables\Columns\TextColumn::make('author_name')
                    ->label('Автор')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата события')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //TODO
            ])
            ->actions([])
            ->bulkActions([]);
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
            'index' => Shop\EventResource\Pages\ListEvents::route('/'),
        ];
    }
}
