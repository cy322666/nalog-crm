<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\Pages\CreateCustomer;
use App\Filament\Resources\CustomerResource\Pages\EditCustomer;
use App\Filament\Resources\CustomerResource\Pages\ListCustomers;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Filament\Resources\CustomerResource\RelationManagers\ContractsRelationManager;
use App\Filament\Resources\CustomerResource\RelationManagers\PaymentsRelationManager;
use App\Models\Customer;
use App\Models\User;
use App\Services\CacheService;
use App\Services\Helpers\ModelHelper;
use Filament\Forms;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use function now;

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

    • Документы
    • Закупки
    • Работы
    • Документация
    • Техническая поддержка
    • Отправки

    • Тип оплаты
    • Дата проведения повторного обследования
    • Дата продления
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

                                        Forms\Components\Select::make('responsible_id')
                                            ->label('Ответственный')
//                                            ->default(Auth::user()->toArray())
                                            ->options(User::all()->pluck( 'name', 'id'))
                                            ->searchable()
                                            ->required(),

                                        Forms\Components\TextInput::make('phone')
                                            ->label('Телефон'),

                                        Forms\Components\TextInput::make('email')
                                            ->label('Почта')
                                            ->email()
                                            ->unique(Customer::class, 'email', fn ($record) => $record),

                                        Forms\Components\Checkbox::make('unscrupulous')
                                            ->label('Недобросовестный')
                                            ->default(false),

                                        Forms\Components\Checkbox::make('debtor')
                                            ->label('Должник')
                                            ->default(false),
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
                                        Forms\Components\TextInput::make('ogrn')
                                            ->label('ОГРН'),

                                        Forms\Components\TextInput::make('region_id')//TODO
                                            ->label('Регион'),

                                        Forms\Components\TextInput::make('address_legal')
                                            ->label('Адрес юридический'),

                                        Forms\Components\TextInput::make('address_real')
                                            ->label('Адрес фактический'),
                                    ])
                                    ->columns(['sm' => 2,])
                                    ->columnSpan(['sm' => 2,]),
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
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Наименование')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Почта')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('inn')
                    ->label('ИНН')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kpp')
                    ->label('КПП')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ogrn')
                    ->label('ОГРН')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('responsible.name')
                    ->label('Ответственный')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('debtor')
                    ->label('Должник')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('unscrupulous')
                    ->label('Недобросовестный')
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

//                Tables\Filters\TernaryFilter::make('type')
//                    ->placeholder('Клиенты и компании')
//                    ->trueLabel('Только контакты')
//                    ->falseLabel('Только компании')
//                    ->queries(
//                        true:  fn (Builder $query) => $query->where('type', 1),
//                        false: fn (Builder $query) => $query->where('type', 2),
//                        blank: fn (Builder $query) => $query,
//                    )
            ])
            ->actions([
                EditAction::make('asd'),
            ])
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
        return parent::getGlobalSearchEloquentQuery();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getRelations(): array
    {
        return [
            ContractsRelationManager::class,
            PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListCustomers::route('/'),
            'create' => CreateCustomer::route('/create'),
            'edit'   => EditCustomer::route('/{record}/edit'),
        ];
    }
}
