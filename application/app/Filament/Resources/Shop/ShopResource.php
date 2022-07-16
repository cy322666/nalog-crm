<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\ShopResource\Pages\CreateShop;
use App\Filament\Resources\Shop\ShopResource\Pages\EditShop;
use App\Filament\Resources\Shop\ShopResource\Pages\ListShops;
use App\Filament\Tables\Actions\ButtonActionShopPay;
use App\Filament\Tables\Actions\ButtonActionShopView;
use App\Models\Currency;
use App\Models\Shop\Shop;
use App\Models\Timezone;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;

class ShopResource extends Resource
{
    protected static ?string $model = Shop::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getFormSchema(Card::class))
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    //TODO optimize queries shop + tariffs
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Название'),
                TextColumn::make('expired_at')->label('Оплачен до'),
                TextColumn::make('tariff.name')->label('Тариф'),//TODO тут ссылка на страницу
            ])
            ->filters([
                //
            ])
            ->actions([
                ButtonActionShopView::make('Перейти'),
                ButtonActionShopPay::make('Оплатить'),
            ])
            ->bulkActions([]);
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
            'index'  => ListShops::route('list/'),
            'create' => CreateShop::route('/create'),
            'edit'   => EditShop::route('/{record}/edit'),
        ];
    }

    public static function getFormSchema(string $layout = Grid::class): array
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
                                ->getSearchResultsUsing(fn (string $query) => Timezone::query()->where('text', 'like', "%{$query}%")->pluck('text', 'id'))
                                ->required(),

                            Placeholder::make(''),

                            //TODO select
                            Select::make('Основная валюта')
                                ->relationship('currency', 'name')
                                ->searchable()
                                ->getSearchResultsUsing(fn (string $query) => Currency::query()->where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                                ->required(),

                            Placeholder::make(''),

                        ])->columns(2),


                    Tabs\Tab::make('Оплата')
                        ->schema([

                            Placeholder::make('')
                                ->content(fn (?Shop $record): string => $record->expired_at ? 'Ваш тариф '.$record->tariff->name.' оплачен до '.$record->expired_at : 'Тестовый период'),

                            Placeholder::make(''),

                            View::make('forms.buttons.settings-pay'),

                        ])->columns(2),


                    Tabs\Tab::make('Сотрудники')
                        ->schema([
                            View::make('forms.buttons.settings-employees'),
                        ]),

//TODO раздел

//                    Tabs\Tab::make('Услуги')
//                        ->schema([
//                            TextInput::make('shop_id')
//                                ->label('Список услуг'),
////                                ->isDisabled(),
//                            TextInput::make('name')
//                                ->label('Список услуг')
//                                ->required()
//                                ->reactive(),
//                        ]),

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

            ])->columnSpan(2),

            Card::make()
                ->schema([
                    Placeholder::make('')
                        ->label('ID аккаунта')
                        ->content(fn (?Shop $record): string => $record->shop_id),

                    View::make('forms.buttons.settings-support'),

//                    View::make('forms.buttons.settings-employees'),
                ])
                ->columnSpan(1),
            ];
    }
}
