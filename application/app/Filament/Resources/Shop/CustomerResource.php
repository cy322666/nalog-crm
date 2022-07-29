<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Forms\Components\TaskInfoEntity;
use App\Filament\Resources\Shop\CustomerResource\Pages;
use App\Filament\Resources\Shop\CustomerResource\RelationManagers;
use App\Models\Shop\Customer;
use App\Services\CacheService;
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
use Squire\Models\Country;

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

    public static function form(Form $form): Form
    {
        return $form
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
                            ->minValue(11)
                            ->maxValue(18)
                            ->mask(
                                fn ($mask) => $mask->pattern('+{7}(000)000-00-00')//TODO msk
                            ),
                        Forms\Components\DatePicker::make('birthday')
                            ->label('Дата рождения'),
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

                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\SpatieTagsInput::make('tags')->type('customers'),
                        ])
                        ->columnSpan(1),
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Почта')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),//TODO make hidden
                Tables\Columns\SpatieTagsColumn::make('tags')
                    ->type('customers'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->date()
                    ->toggleable(),
            ])
            ->defaultSort('created_at')
            ->filters([
//                Tables\Filters\Filter::make('created_at')
//                    ->form([
//                        Forms\Components\SpatieTagsInput::make('tag')
//                            ->label('Тег')
//                            ->placeholder(fn ($state): string => ''),
//                    ])
//                    ->query(function (Builder $query, array $data): Builder { //TODO search by tag
//                       // dd($data);
//                        if (count($data) > 0) {
//                            dd($data);
//                        }
//                        return $query
//                            ->when(
//                                $data,
////                                $data['tag'],
//                                fn (Builder $query, $date): Builder => $query->where('name', $date),
//                            );
//                    }),
            ])
            ->actions([])
            ->bulkActions([

                //TODO mass actions
                Tables\Actions\BulkAction::make('actions')
//                    ->action(fn (Collection $records) => $records->each->activate())
//                    ->requiresConfirmation()
                    ->color('warning')
                    ->icon('heroicon-o-check'),
            ]);
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->where('shop_id', CacheService::getAccountId());
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('shop_id', CacheService::getAccountId());
    }

    public static function getRelations(): array
    {
        return [
            //TODO on
//          RelationManagers\CommentsRelationManager::class,
            RelationManagers\OrdersRelationManager::class,
            RelationManagers\TasksRelationManager::class,
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
