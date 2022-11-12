<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\RoleResource\Pages\CreateRole;
use App\Filament\Resources\Shop\RoleResource\Pages\EditRole;
use App\Filament\Resources\Shop\RoleResource\Pages\ListRoles;
use App\Filament\Resources\Shop\RoleResource\Pages\ViewRole;
use App\Models\Role;
use App\Services\CacheService;
use App\Services\Roles\RoleManager;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $slug = 'role';

    protected static ?string $recordTitleAttribute = 'name';

    protected static bool $isGloballySearchable = false;

    public static function form(Form $form) : Form
    {
        return $form
            ->schema(
                Grid::make()
                    ->schema([
                        Card::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Название')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Hidden::make('shop_id')
                                    ->default(CacheService::getAccount()->id),
                            ])
                            ->columns([
                                'sm' => 2,
                                'lg' => 3,
                            ]),
                        Tabs::make('Permissions')
                            ->tabs([
                                Tabs\Tab::make('permission_groups')
                                    ->label('Группы прав')
                                    ->visible(fn (): bool => true)
                                    ->reactive()
                                    ->schema([
                                        Grid::make([
                                            'sm' => 2,
                                            'lg' => 3,
                                        ])
                                            ->schema(static::getResourceEntitiesSchema())
                                            ->columns([
                                                'sm' => 2,
                                                'lg' => 3,
                                            ]),
                                    ]),
//TODO v2
//                            Forms\Components\Tabs\Tab::make(__('filament-shield::filament-shield.pages'))
//                                ->visible(fn (): bool => true)
//                                ->reactive()
//                                ->schema([
//                                    Forms\Components\Grid::make([
//                                        'sm' => 3,
//                                        'lg' => 4,
//                                    ])
//                                    ->schema(static::getPageEntityPermissionsSchema())
//                                    ->columns([
//                                        'sm' => 3,
//                                        'lg' => 4,
//                                    ]),
//                                ]),
                            ])
                            ->columnSpan('full'),
                    ]),

            );
    }

    public static function getResourceEntitiesSchema(): ?array
    {
        return collect(RoleManager::$resources)->sortKeys()->reduce(function ($entities, $entity) {

            $entities[] = Card::make()
                ->extraAttributes(['class' => 'border-0 shadow-lg'])
                ->schema([
                    Fieldset::make('Permissions')
                        ->label($entity['label'])
                        ->extraAttributes(['class' => 'text-primary-600','style' => 'border-color:var(--primary)'])
                        ->columns([
                            'default' => 2,
                            'xl' => 2,
                        ])
                        ->schema(static::getResourceEntityPermissionsSchema($entity)),
                ])
                ->columns(2)
                ->columnSpan(1);

            return $entities;

        }, collect())
            ->toArray();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('shop_id', CacheService::getAccount()->id);
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public static function getResourceEntityPermissionsSchema($entity): ?array
    {
        return collect($entity['permissions'])
            ->reduce(function ($permissions, $permission) use ($entity) {

                $permissions[] = Checkbox::make($permission)
                    ->label($entity['titles'][$permission]) //соотношение permissions -> titles[{permissions}]
                    ->extraAttributes(['class' => 'text-primary-600'])
                    ->default(true)
                    ->afterStateHydrated(function (Closure $set, Closure $get, $record) use ($permission) {

                        //проверка наличия такого права у этой роли
                        $set($permission, (bool)$record
                            ?->permissions()
                            ->where('slug', $permission)
                            ->exists() ?? false);
                    });

                return $permissions;

            }, collect())
            ->toArray();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('name')
                    ->label('Название')
                    ->formatStateUsing(fn ($state): string => Str::headline($state))
                    ->colors(['primary']),
                Tables\Columns\BadgeColumn::make('permissions_count')
                    ->label('Уровень прав')
                    ->counts('permissions')
                    ->colors(['success']),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime(),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'view'   => ViewRole::route('/{record}'),
            'edit'   => EditRole::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Роль';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Роли';
    }

//    protected static function getPageEntityPermissionsSchema(): ?array
//    {
//        return collect(FilamentShield::getPages())->sortKeys()->reduce(function ($pages, $page) {
//            $pages[] = Forms\Components\Grid::make()
//                    ->schema([
//                        Forms\Components\Checkbox::make($page)
//                            ->label(FilamentShield::getLocalizedPageLabel($page))
//                            ->inline()
//                            ->afterStateHydrated(function (Closure $set, Closure $get, $record) use ($page) {
//                                if (is_null($record)) {
//                                    return;
//                                }
//
//                                $set($page, $record->checkPermissionTo($page));
//
//                                static::refreshSelectAllStateViaEntities($set, $get);
//                            })
//                            ->reactive()
//                            ->afterStateUpdated(function (Closure $set, Closure $get, $state) {
//                                if (! $state) {
//                                    $set('select_all', false);
//                                }
//
//                                static::refreshSelectAllStateViaEntities($set, $get);
//                            })
//                            ->dehydrated(fn ($state): bool => $state),
//                    ])
//                    ->columns(1)
//                    ->columnSpan(1);
//
//            return $pages;
//        }, []);
//    }
}
