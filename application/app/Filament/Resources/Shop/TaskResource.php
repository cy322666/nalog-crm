<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop;
use App\Filament\Resources\Shop\TaskResource\Widgets\TaskStats;
use App\Models\Shop\Task;
use App\Services\CacheService;
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
use Webbingbrasil\FilamentAdvancedFilter\Filters\BooleanFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\DateFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\NumberFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\TextFilter;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $slug = 'tasks';//TODO урл?

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $recordTitleAttribute = 'title';

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
        return parent::getGlobalSearchEloquentQuery();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'text', 'task_id'];
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('text')
                    ->label('Описание')
                    ->searchable()
                    ->getStateUsing(fn($record): ?string => mb_strimwidth($record->text, 0, 50, "...")),
                Tables\Columns\TextColumn::make('model')
                    ->label('Объект')
                    ->url(function ($record) {

                        return $record->model_type::$resource::getUrl('edit', [$record->model_id]);//TODO refactoring
                    })
                    ->sortable()
                    ->getStateUsing(function ($record) {

                        return ($record->model_type::query()->find($record->model_id)->name);
                    }),
                Tables\Columns\TextColumn::make('responsible.name')
                    ->label('Исполнитель')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Автор')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создана')
                    ->sortable()
                    ->dateTime()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('execute_at')
                    ->label('Дата выполнения')
                    ->sortable()
                    ->dateTime()
                    ->toggleable(),
//                Tables\Columns\BooleanColumn::make('failed')
//                    ->label('Была просрочена')
//                    ->toggleable(),
            ])
            ->filters([

                //TODO https://github.com/webbingbrasil/filament-advancedfilter
                ///resources/lang/vendor/filament-advancedfilter]

//                NumberFilter::make('quantity'),//

//                TextFilter::make('title'),//

//                DateFilter::make('created_at'),//TODO dont work

//                BooleanFilter::make('is_active'),//

                Tables\Filters\Filter::make('created_at')
                    ->form([
//                        DatePicker::make('created_at')
//                            ->label('Создана после'),
                        DatePicker::make('execute_at')
                            ->label('Выполнить до'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
//                            ->when(
//                                $data['created_at'],
//                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
//                            )
                            ->when(
                                $data['execute_at'],
                                fn(Builder $query, $date): Builder => $query->whereDate('execute_at', '<=', $date),
                            );
                    }),
//TODO просрочены
//TODO Менеджеры
//TODO Авторы
//TODO Закрытые
                Tables\Filters\SelectFilter::make('responsible')
                    ->label('Ответственный')
                    ->relationship('responsible', 'name')
            ])
            ->actions([
//                Tables\Actions\EditAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            TaskStats::class,
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
            'index'  => Shop\TaskResource\Pages\ListTasks::route('/'),
            'kanban' => Shop\TaskResource\Pages\KanbanTask::route('/kanban'),
        ];
    }
}
