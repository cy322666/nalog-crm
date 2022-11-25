<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Forms\Components\TaskInfoEntity;
use App\Filament\Resources\Shop\CustomerResource\Pages;
use App\Filament\Resources\Shop\CustomerResource\RelationManagers;
use App\Models\Shop\Customer;
use App\Models\User;
use App\Services\CacheService;
use App\Services\Helpers\ModelHelper;
use Filament\Forms;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Squire\Models\Country;
use Ysfkaya\FilamentPhoneInput\PhoneInput;

class CustomerResource extends Resource
{
    public const MODEL_TYPE = 1;

    protected static ?string $model = Customer::class;

    protected static ?string $pluralModelLabel = 'Клиенты';

    protected static ?string $slug = 'customers';

    protected static ?string $recordTitleAttribute = 'name';//TODO?

    protected static ?string $navigationLabel = 'Клиенты';

    protected static ?string $navigationIcon = 'heroicon-o-user-add';

    protected static ?int $navigationSort = 1;//TODO ?

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Телефон' => $record->phone,
            'Почта'   => $record->email,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'phone', 'email', 'customer_id'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    /**
     * @throws \Exception
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Heading')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Основное')
                            ->schema([
                                Forms\Components\Card::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Имя')
                                            ->required(),
                                        Forms\Components\TextInput::make('email')
                                            ->label('Почта')
                                            ->email()
                                            ->unique(Customer::class, 'email', fn ($record) => $record),

                                        Forms\Components\TextInput::make('phone')
                                            ->label('Телефон'),
                                        Forms\Components\DatePicker::make('birthday')
                                            ->label('Дата рождения'),

                                        Forms\Components\Select::make('type')
                                            ->label('Тип')
                                            ->required()
                                            ->options([
                                                1 => 'Контакт',
                                                2 => 'Компания',
                                            ])
                                    ])
                                    ->columns(['sm' => 2,])
                                    ->columnSpan(['sm' => 2,]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Реквизиты')
                            ->schema([
                                Forms\Components\Card::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('inn')
                                            ->label('ИНН'),
                                        Forms\Components\TextInput::make('kpp')
                                            ->label('КПП'),
                                        Forms\Components\TextInput::make('rs')
                                            ->label('Р/с'),
                                    ])
                                    ->columns(['sm' => 2,])
                                    ->columnSpan(['sm' => 2,]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Маркетинг')
                            ->schema([
                                //utms..
                            ]),
                    ])
                    ->columns([
                        'sm' => 2,
                    ])
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                Forms\Components\Group::make([
                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\TextInput::make('customer_id')
                                ->label('ID')
                                ->default(
                                    ModelHelper::generateId(self::$model, 'customer_id')
                                )
                                ->disabled(),
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Создан')
                                ->content(fn (?Customer $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Последнее обновление')
                                ->content(fn (?Customer $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                        ])
                        ->columnSpan(1),

//                    Forms\Components\Card::make()
//                        ->schema([
//                            Forms\Components\SpatieTagsInput::make('tags')->type('customers'),
//                        ])
//                        ->columnSpan(1),

                    Forms\Components\Hidden::make('shop_id')
                        ->default(CacheService::getAccount()->id),
                    Forms\Components\Hidden::make('creator_id')
                        ->default(Auth::user()->id)
                ]),
            ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_id')
                    ->label('ID')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('creator_id')
                    ->label('Создатель')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Почта')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Тип')
                    ->enum([
                        1 => 'Контакт',
                        2 => 'Компания',
                    ])
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
//                Tables\Columns\SpatieTagsColumn::make('tags')
//                    ->label('Теги')
//                    ->type('customers'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at')
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),//TODO check
                        Forms\Components\DatePicker::make('created_until')
                            ->placeholder(fn ($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                Tables\Filters\SelectFilter::make('creator_id')
                    ->label('Создатель')
                    ->options(User::cacheAll()->pluck('name', 'id')->toArray())
                    ->multiple()
                    ->attribute('creator_id'),

                Tables\Filters\TernaryFilter::make('type')
                    ->placeholder('Клиенты и компании')
                    ->trueLabel('Только контакты')
                    ->falseLabel('Только компании')
                    ->queries(
                        true:  fn (Builder $query) => $query->where('type', 1),
                        false: fn (Builder $query) => $query->where('type', 2),
                        blank: fn (Builder $query) => $query,
                    )
            ])
            ->actions([])
            ->bulkActions([

                //TODO mass actions
//                Tables\Actions\BulkAction::make('actions')
////                    ->action(fn (Collection $records) => $records->each->activate())
////                    ->requiresConfirmation()
//                    ->color('warning')
//                    ->icon('heroicon-o-check'),
            ]);
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->where('shop_id', CacheService::getAccount()->id);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('shop_id', CacheService::getAccount()->id);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrdersRelationManager::class,
            RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCustomers::route('/'),
//            'view'   => Pages\ViewCustomer::route('/{record}'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit'   => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
