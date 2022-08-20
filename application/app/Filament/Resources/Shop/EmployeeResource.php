<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\EmployeeResource\Pages;
use App\Models\Shop\TaskType;
use App\Models\User;
use App\Services\CacheService;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Имя')
                                    ->required()
                                    ->reactive(),
                                //TODO select icons
                                TextInput::make('email')
                                    ->label('Почта')
                                    ->required()
                                    ->reactive(),
                                //TODO select color
                                TextInput::make('password')
                                    ->label('Пароль')
                                    ->password()
                                //TODO avatar
                            ]),
                    ])
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                Card::make()
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (?User $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (?User $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->join('shop_user', 'users.id', '=', 'shop_user.user_id')
            ->where('shop_user.shop_id', CacheService::getAccountId());
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->join('shop_user', 'users.id', '=', 'shop_user.user_id')
            ->where('shop_user.shop_id', CacheService::getAccountId());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Почта')
                    ->sortable(),
                BadgeColumn::make('active')
                    ->sortable()
                    ->label('Статус')
                    ->enum([
                        false => 'Не активен',
                        true  => 'Активен',
                    ])
                    ->colors([
                        'danger'  => false,
                        'success' => true,
                    ]),
                Tables\Columns\TextColumn::make('role.name')
                    ->label('Роль')
                    ->sortable(),
            ])
            ->filters([])
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
