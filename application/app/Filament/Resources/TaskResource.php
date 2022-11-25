<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Shop;
use App\Filament\Resources\TaskResource\Pages\KanbanTask;
use App\Filament\Resources\TaskResource\Pages\ListTasks;
use App\Models\Shop\Task;
use App\Services\CacheService;
use App\Services\Helpers\ModelHelper;
use Exception;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $slug = 'tasks';

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Задачи';

    protected static ?string $pluralLabel = 'Задачи';

    protected static ?string $modelLabel = 'Задача';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return Task::query()->where('shop_id', CacheService::getAccountId());
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'ID' => $record->task_id,
            'Название' => $record->title,
//            'Описание' => $record->text,
//            'Ответственный' => optional($record->responsible)->name,
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->where('shop_id', CacheService::getAccountId());
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
//        return ['title', 'text', 'task_id'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([])
                    ->schema([
                        Card::make()
                            ->schema([
                                TextInput::make('title')
                                    ->label('Название')
                                    ->required()
                                    ->reactive(),
                                Textarea::make('text')
                                    ->label('Текст')
                                    ->autosize()
                                    ->required()
                                    ->reactive(),
                                Select::make('responsible_id')
                                    ->relationship('responsible', 'name')
                                    ->required(),
                                DateTimePicker::make('execute_at')
                                    ->firstDayOfWeek(1)
                                    ->label('Выполнить до')
                                    ->withoutSeconds()
                                    ->required(),
                                TextInput::make('execute_comment')
                                    ->label('Результат выполнения')
                                    ->helperText('Введите, чтобы выполнить задачу')
                                    ->reactive(),
                            ])->columns(1),
                    ]),

                //TODO сбоку инфа краткая о таске полезная
                Group::make([])
                    ->schema([
                        Card::make()
                            ->schema([
                                ViewField::make('')
                                    ->view('forms.components.task-work-days-label')//TODO static
                                    ->label('0'),//TODO
                                ViewField::make('')
                                    ->view('forms.components.task-count-failed-label')//TODO static
                                    ->label('0')//TODO
                            ]),

                    ])->columns(1),
            ])->columns(2);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('task_id')
                    ->label('ID')
                    ->toggleable(true)
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('is_execute')
                    ->label('Статус')
                    ->getStateUsing(function (Task $task) {

                        if ($task->is_failed  == true) return 'fail';
                        if ($task->is_execute == true) return 'success';

                        return 'work';
                    })
                    ->enum([
                        'work' => 'Р',
                        'fail' => 'Просрочена',
                        'success'  => 'Выполнена',
                    ])
                    ->icons([
                        'heroicon-o-ban' => fn ($state) => $state == 'work',
                        'heroicon-o-badge-check'  => fn ($state): bool => $state === true,
                    ])
                    ->colors([
                        'danger'  => 'fail',
                        'success' => 'success',
                        'primary' => 'work',
                    ])
                    ->description(fn (Task $record): string => $record->name, position: 'above')
                    ->extraAttributes(['class' => 'w-40']),
                Tables\Columns\TextColumn::make('description')
                    ->label('Описание')
                    ->searchable()
                    ->getStateUsing(fn($record): ?string => mb_strimwidth($record->description, 0, 50, "...")),
                Tables\Columns\TextColumn::make('model')
                    ->label('Объект')
                    ->url(function ($record) {

                        $resource = ModelHelper::getEntityResource($record->model_type);

                        return $resource::getUrl('edit', [$record->model_id]);
                    })
                    ->sortable()
                    ->getStateUsing(function ($record) {

                        return ModelHelper::getEntityClass($record->model_type)::query()->find($record->model_id)->name;
                    }),
                Tables\Columns\TextColumn::make('responsible.name')
                    ->label('Исполнитель')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Автор')
                    ->sortable()
                    ->toggleable(true)
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создана')
                    ->sortable()
                    ->dateTime()
                    ->toggleable(true)
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('execute_at')
                    ->label('Дата выполнения')
                    ->sortable()
                    ->toggleable(true)
                    ->toggledHiddenByDefault()
                    ->dateTime(),
            ])
            ->filters([

                Tables\Filters\TernaryFilter::make('date_execute')
                    ->label('Период выполнения')
                    ->placeholder('Все время')
                    ->trueLabel('Завтра')
                    ->falseLabel('В течении недели')
                    ->queries(
                        true:  fn (Builder $query) => $query->where('execute_to', now()->addDay()),
                        false: fn (Builder $query) => $query->where('execute_to', now()->addDays(7)),
                        blank: fn (Builder $query) => $query->where('execute_to', '!=', null),
                    ),

                Tables\Filters\SelectFilter::make('responsible_id')
                    ->label('Исполнитель')
                    ->options(CacheService::getAccount()->users->pluck('name', 'id'))
                    //->relationship('responsible', 'name')
                    ->default(Auth::user()->id),

                Tables\Filters\SelectFilter::make('author')
                    ->label('Автор')
                    ->relationship('author', 'name'),

                Tables\Filters\TernaryFilter::make('status')
                    ->label('Статус')
                    ->default(null)
                    ->placeholder('Вcе')
                    ->trueLabel('Выполнено')
                    ->falseLabel('Просрочено')
                    ->queries(
                        true:  fn (Builder $query) => $query->where('is_execute', true),
                        false: fn (Builder $query) => $query->where('is_failed', true),
                        blank: fn (Builder $query) => $query,
                    ),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_at')
                            ->label('Дата создания'),
                        DatePicker::make('execute_at')
                            ->label('Выполнить до'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_at'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['execute_at'],
                                fn(Builder $query, $date): Builder => $query->whereDate('execute_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getWidgets(): array
    {
        return [
//          TODO   TaskStats::class,
        ];
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
            'index'  => ListTasks::route('/'),
//            'kanban' => KanbanTask::route('/kanban'),
        ];
    }
}
