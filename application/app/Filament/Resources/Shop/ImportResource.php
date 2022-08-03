<?php

namespace App\Filament\Resources\Shop;

use App\Events\Shop\Push\Task\TaskCreated;
use App\Filament\Resources\Shop\ImportResource\Pages;
use App\Models\Shop\Import;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;

class ImportResource extends Resource
{
    protected static ?string $model = Import::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('type')
                            ->label('Тип загружаемых данных')
                            ->required()
                            ->options([
                                1 => 'Клиенты',
                                2 => 'Клиенты + Заказы',
                                3 => 'Оплаты',
                            ]),
                        Forms\Components\FileUpload::make('name')
    //                                ->acceptedFileTypes(['xlsx', 'csv'])
                            ->directory(Storage::disk(Config::get('crm.storage_disk'))->get('import'))
                            ->helperText('Только файлы Excel ')
                            ->required()
                    ])->maxWidth('2xl'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('count_rows')
                    ->label('Всего строк'),
                Tables\Columns\TextColumn::make('count_imported')
                    ->label('Выгружено'),
                Tables\Columns\BooleanColumn::make('is_completed')
                    ->label('Закончено'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListImports::route('/'),
            'create' => Pages\CreateImport::route('/create'),
            'view'   => Pages\ViewImport::route('/{record}'),
            'edit'   => Pages\EditImport::route('/{record}/edit'),
        ];
    }
}
