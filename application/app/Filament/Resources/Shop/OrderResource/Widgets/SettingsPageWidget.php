<?php

namespace App\Filament\Resources\Shop\OrderResource\Widgets;

use App\Models\Currency;
use App\Models\Shop\Shop;
use App\Models\Timezone;
use App\Services\CacheService;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Concerns\HasFormActions;
use Filament\Widgets\Widget;

class SettingsPageWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    private Shop $shop;

    protected static string $view = 'filament.resources.shop.order-resource.widgets.orders.settings-page-widget';

    public function mount(): void
    {
        $this->shop = Shop::query()->find(CacheService::getAccountId());

        //TODO Источники custom
        //TODO Причины отказа custom
        //TODO поля custom
        //Статусы
        $this->form->fill([
            'statuses' => $this->shop->statuses->toArray(),
        ]);
    }

    public static function getFormSchema(string $layout = Grid::class): array
    {
        return [
            Tabs::make('')
                ->tabs([

                           Tabs\Tab::make('Статусы')
                               ->schema([
                                   Placeholder::make(''),

//                                   TextInput::make('sources.name')->dehydrateStateUsing(fn($record) => (dd($record))),
                               ])->columns(2),
                ]),
        ];
    }

    public function render() : \Illuminate\View\View
    {
        return view('forms.pages.order-settings');
    }
}
