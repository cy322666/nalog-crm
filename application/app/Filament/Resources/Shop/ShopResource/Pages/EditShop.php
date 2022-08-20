<?php

namespace App\Filament\Resources\Shop\ShopResource\Pages;

use App\Filament\Resources\Shop\EmployeeResource;
use App\Filament\Resources\Shop\ShopResource;
use App\Models\Currency;
use App\Models\Shop\Shop;
use App\Models\Timezone;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class EditShop extends EditRecord
{
    protected static string $resource = ShopResource::class;
//cog icon TODO
    protected function getActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema(static::getFormSchema(Card::class))
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    protected function getTitle(): string
    {
        return "\n";
    }

    public function getFormSchema(string $layout = Grid::class): array
    {
        return [

            Section::make('Настройки')
                ->schema([

                    Tabs::make('Heading')
                        ->tabs([
                            Tabs\Tab::make('Общие')
                                ->schema([
                                    TextInput::make('name')
                                        ->label('Название')
                                        ->required()
                                        ->reactive(),
                                    Placeholder::make('')
                                        ->content('*Видно только коллегам'),

                                    Select::make('Часовой пояс')
                                        ->relationship('timezone', 'text')
                                        ->searchable()
                                        ->getSearchResultsUsing(fn (string $query) => Timezone::query()
                                            ->where('text', 'like', "%{$query}%")
                                            ->pluck('text', 'id')
                                        )
                                        ->required(),

                                    Placeholder::make(''),

                                    //TODO select
                                    Select::make('Основная валюта')
                                        ->relationship('currency', 'name')
                                        ->searchable()
                                        ->getSearchResultsUsing(fn (string $query) => Currency::query()
                                            ->where('name', 'like', "%{$query}%")
                                            ->pluck('name', 'id')
                                        )
                                        ->required(),

                                    Placeholder::make(''),

                                ]),


                            Tabs\Tab::make('Оплата')
                                ->schema([

                                    Placeholder::make('')
                                        ->content(fn (?Shop $record): string => 'Ваш тариф '.$record->tariff->name.' активен до '.$record->expired_at),

                                    Placeholder::make(''),

                                    View::make('forms.buttons.settings-pay'),

                                ]),


                            Tabs\Tab::make('Сотрудники')
                                ->schema([
                                    View::make('forms.buttons.settings-employees'),
                                ]),

                            Tabs\Tab::make('Автоматизация')
                                ->schema([
                                    Placeholder::make('')
                                        ->label('В разработке'),
                                ]),

                            Tabs\Tab::make('Интеграции')
                                ->schema([
                                    Placeholder::make('')
                                        ->label('В разработке'),
                                ]),
                        ]),
                    Group::make([
                        Card::make()
                            ->schema([
                                Placeholder::make('')
                                    ->label('ID аккаунта')
                                    ->content(fn (?Shop $record): string => $record->shop_id),

                                View::make('forms.buttons.settings-support'),

//                    View::make('forms.buttons.settings-employees'),
                            ])
                    ])
                        ->columns(1)
                        ->columnSpan(1),


                ])
                ->columns()
                ->columnSpan(2),
        ];
    }

    protected function getSavedNotificationMessage(): ?string
    {
        return '';
    }

    public function payButtonClick(int $shop_id)
    {
        $this->redirect(Config::get('crm.url_support'));//$shop_id
    }

    public function employeesButtonClick()
    {
        $this->redirect(EmployeeResource::getUrl());
    }

    public function supportButtonClick()
    {
        $this->redirect(Config::get('crm.url_support'));//$shop_id
    }
}
