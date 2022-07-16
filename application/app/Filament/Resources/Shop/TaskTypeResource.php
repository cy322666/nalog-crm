<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop;
use App\Filament\Resources\TaskTypeResource\Pages;
use App\Filament\Resources\TaskTypeResource\RelationManagers;

use App\Models\Shop\TaskType;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class TaskTypeResource extends Resource
{
    protected static ?string $model = TaskType::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('title')
                                    ->label('Название')
                                    ->required()
                                    ->reactive(),
                                //TODO select icons
                                 TextInput::make('icon')
                                     ->label('Иконка')
                                     ->required()
                                     ->reactive(),
                                //TODO select color
                                TextInput::make('color')
                                    ->label('Цвет')
                                    ->required()
                                    ->reactive()
                            ]),
                    ])
                    //TODO dont work event
//                    ->registerListeners([
//                        'save' => [
//                            function (Component $component): void {
//
//                                dd($component->data());
//                            }]
//                        ]
//                    )
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                Card::make()
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (?TaskType $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (?TaskType $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    ])
                    ->columnSpan(1),
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            Tables\Columns\TextColumn::make('title')
                ->label('Название')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('color')
                ->label('Цвет')
                ->searchable()
                ->sortable()
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Shop\TaskTypeResource\Pages\ListTaskTypes::route('/'),
            'create' => Shop\TaskTypeResource\Pages\CreateTaskType::route('/create'),
            'edit' => Shop\TaskTypeResource\Pages\EditTaskType::route('/{record}/edit'),
        ];
    }
}
