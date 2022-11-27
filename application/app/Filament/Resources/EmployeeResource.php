<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
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
                                TextInput::make('email')
                                    ->label('Почта')
                                    ->required()
                                    ->reactive(),
                                TextInput::make('password')
                                    ->label('Пароль')
                                    ->password(),
                                  Forms\Components\Select::make('password')
                                      ->label('Роль')
                                      ->options([])
//                                      ->default('')
                                      ->required()
                            ]),
                    ])
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                Card::make()
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Создан')
                            ->content(fn (?User $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Placeholder::make('updated_at')
                            ->label('Обновлен')
                            ->content(fn (?User $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    //TODO не сейвит роль

    public static function getEloquentQuery(): Builder
    {
        //TODO какаааака
        return parent::getEloquentQuery();//->whereBelongsTo(CacheService::getAccount(), 'shop');//->where('shop_id', CacheService::getAccountId());//null;//->users()->getQuery();
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
//        return CacheService::getAccount()->users()->getQuery();

            return parent::getEloquentQuery();
//            ->join('shop_user', 'users.id', '=', 'shop_user.user_id')
//            ->where('shop_user.shop_id', CacheService::getAccountId());
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
            'index'  => \App\Filament\Resources\EmployeeResource\Pages\ListEmployees::route('/'),
            'create' => \App\Filament\Resources\EmployeeResource\Pages\CreateEmployee::route('/create'),
            'edit'   => \App\Filament\Resources\EmployeeResource\Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
