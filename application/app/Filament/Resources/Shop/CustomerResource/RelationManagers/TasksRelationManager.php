<?php

namespace App\Filament\Resources\Shop\CustomerResource\RelationManagers;

use Akaunting\Money\Currency;
use App\Filament\Resources\Shop\OrderResource;
use App\Filament\Resources\Shop\TaskResource;
use App\Models\Shop\Customer;
use App\Models\Shop\Shop;
use App\Models\Shop\Task;
use App\Models\User;
use App\Services\CacheService;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyThroughRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TasksRelationManager extends HasManyThroughRelationManager
{
    protected static string $relationship = 'tasks';

    //TODO check double
    //protected bool $allowsDuplicates = true;

    protected static ?string $recordTitleAttribute = 'task_id';

    //TODO tz
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        TextInput::make('title')
                            ->label('Название')
                            ->required()
                            ->reactive(),
                        Textarea::make('text')
                            ->label('Текст')
                            ->required()
                            ->reactive(),
                    ])
                    ->columnSpan(1),
                Forms\Components\Group::make()
                    ->schema([
                        DateTimePicker::make('execute_at')
                            ->withoutSeconds()
                            ->firstDayOfWeek(7),
                        DateTimePicker::make('execute_to')
                            ->firstDayOfWeek(7)
                            ->withoutSeconds()
                            ->label('Выполнить до')
                            ->required(),

                        Forms\Components\Select::make('responsible_id')
                            ->label('Ответственный')
                            ->searchable()
                            ->getSearchResultsUsing(function (string $query) {

                                return Shop::query()->find(CacheService::getAccountId())
                                    ->users()
                                    ->where('name', 'like', "%{$query}%")
                                    ->pluck('name', 'user_id');
                            })
//                            ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->name),
                        ])
                        ->columnSpan(1)
            ->columns([
                'sm' => 1,
                'lg' => null,
            ]),
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['model_type'] = Customer::class;
        $data['created_employee_id'] = Auth::user()->id;
        $data['shop_id'] = CacheService::getAccountId();
        $data['task_id'] = Task::generateId();
        $data['is_failed'] = (bool)(Carbon::parse($data['execute_to']) < Carbon::now());

        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('task_id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->sortable(),

                Tables\Columns\TextColumn::make('text')
                    ->label('Описание')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_employee_id')//TODO created_id
                    ->label('Постановщик')
                    ->formatStateUsing(fn ($state) => Str::headline($state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('responsible_id')
                    ->label('Ответственный')
                    ->sortable(),

                Tables\Columns\TextColumn::make('execute_to')
                    ->label('Дата выполнения')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\BooleanColumn::make('is_execute')
                    ->label('Выполнена')
                    ->trueColor('primary')
                    ->falseColor('warning')
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle'),

                Tables\Columns\BadgeColumn::make('is_failed')
                    ->label('Статус')
                    ->colors([
                        'danger'  => fn ($state): bool => $state === true,//'Просрочена',
                        'success' => fn ($state): bool => $state === false,//'В работе',//TODO name
                    ]),

                Tables\Columns\TextColumn::make('execute_comment')
                    ->label('Результат')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([]);
    }
}
