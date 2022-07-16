<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\NotificationResource\Pages;
use App\Models\Shop\Notification;
use App\Models\User;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class NotificationResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getEloquentQuery(): Builder
    {
        return \App\Models\Shop\Notification::query()
            ->where('notifiable_id', Auth::user()->id)
            ->where('notifiable_type', User::class)
            ->orderByDesc('created_at');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('message')
                    ->label('Событие')
                    ->searchable()
                    ->url(fn ($record) => $record->link)
                    ->sortable(),
                TextColumn::make('level')
                    ->label('Тип')
                    ->enum([
                        'info'  => 'Оповещение',
                        'error' => 'Ошибка',
                    ])
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListNotifications::route('/'),
        ];
    }
}
