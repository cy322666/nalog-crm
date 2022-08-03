<?php

namespace App\Filament\Resources\Shop\ImportResource\Pages;

use App\Filament\Resources\Shop\CustomerResource;
use App\Filament\Resources\Shop\ImportResource;
use App\Imports\CustomersImport;
use App\Models\Shop\Import;
use App\Services\CacheService;
use App\Services\ModelHelper;
use Exception;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ViewImport extends ViewRecord
{
    protected static string $resource = ImportResource::class;

    /**
     * @throws Exception
     */
    protected function form(Form $form): Form
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
                        ])
                        ->disabled(true),
                    TextInput::make('count_rows')
                        ->label('Строк')
                        ->disabled(true),

                    TextInput::make('count_imported')
                        ->label('Строк выгружено')
                        ->disabled(true),

                    TextInput::make('is_completed')
                        ->label('Статус')
                        ->disabled(true),
                ])
                ->columns([
                    'sm' => 2,
                ])
                ->columnSpan([
                    'sm' => 2,
                ]),
            Group::make([
                Card::make()
                    ->schema([
                        TextInput::make('id')//TODO import_id
                            ->label('ID')
                            ->default(
                                ModelHelper::generateId(Import::class, 'id')
                            )
                            ->disabled(),

                        Placeholder::make('created_at')
                            ->label('Создан')
                            ->content(fn (?Import $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Placeholder::make('updated_at')
                            ->label('Последнее обновление')
                            ->content(fn (?Import $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    ])
                    ->columnSpan(1),
            ]),
        ])
        ->columns([
            'sm' => 3,
            'lg' => null,
        ]);
    }

    protected function getFooterWidgets(): array
    {
        return [
            ImportResource\Widgets\SettingsForm::class,
        ];
    }

    protected function getActions(): array
    {
        return [
            Actions\Action::make('start')
                ->label('Импорт')
                ->action('startImport'),
            Actions\DeleteAction::make(),
        ];
    }

    public function startImport()
    {
        Excel::import(new CustomersImport(
            $this->record->shop,
            $this->record,
        ), Config::get('crm.storage_disk').'/'.$this->record->name);
    }
}
