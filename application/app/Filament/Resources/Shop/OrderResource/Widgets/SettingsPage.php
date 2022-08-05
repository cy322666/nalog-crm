<?php

namespace App\Filament\Resources\Shop\OrderResource\Widgets;

use App\Models\Currency;
use App\Models\Shop\OrderStatus;
use App\Models\Shop\Shop;
use App\Models\Timezone;
use App\Services\CacheService;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Actions\Action;
use Filament\Pages\Concerns\HasFormActions;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Log;

class SettingsPage extends Widget implements HasForms
{
    use InteractsWithForms;

    public Shop $shop;

    public function mount(): void
    {
        $this->shop = Shop::query()->find(CacheService::getAccountId());

        $statuses = $this->shop->statuses;

        $this->form->fill([
            'name'     => $this->shop->name,
            'statuses' => $statuses->where('is_system', false)->toArray(),
            'new'  => $statuses->where('status_id', OrderStatus::NEW_STATUS_ID)->first(),
            'win'  => $statuses->where('status_id', OrderStatus::WIN_STATUS_ID)->first(),
            'lost' => $statuses->where('status_id', OrderStatus::LOST_STATUS_ID)->first(),
        ]);
    }

    public static function getFormSchema(string $layout = Grid::class): array
    {
        return [
            Tabs::make('settings')
                ->schema([
                    Tabs\Tab::make('Статусы')
                        ->schema([
                            Card::make([
                                TextInput::make('new.name')
                                    ->disabled(true)
                                    ->label('new.status_id'),
                            ]),
                            Repeater::make('statuses')
                                ->schema([
                                    TextInput::make('name')
                                        ->label('')
                                        ->required(),
                                ])
                                ->label('Активные статусы')
                                ->orderable('order')
                                ->createItemButtonLabel('+Статус')
                                ->maxItems(10),
                            Card::make([
                                TextInput::make('win.name')
                                    ->disabled(true)
                                    ->label('win.status_id'),

                                TextInput::make('lost.name')
                                    ->disabled(true)
                                    ->label('lost.status_id'),
                            ])
                        ]),
                ])

        ];
    }


    /**
     * @return void обработка кнопки формы
     */
    public function save()
    {
        $this->shop->setStatuses($this->form->getState()['statuses']);
    }

    public function render() : \Illuminate\View\View
    {
        return view('forms.pages.order-settings');
    }
}
