<?php

namespace App\Filament\Resources\Shop\OrderResource\Pages;

use App\Filament\Resources\Shop\OrderResource;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\CreateAction;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Illuminate\Support\Facades\Log;

class ListSettingOrder extends Page
{
    protected static ?string $title = 'Настройки для заказов';

    protected static string $resource = OrderResource::class;

    protected static string $view = 'filament.pages.order-settings';

    protected function getHeaderWidgets(): array
    {
        return [
            OrderResource\Widgets\SettingsPage::class,
        ];
    }
}
