<?php

namespace App\Filament\Resources\Shop\NotificationResource\Pages;

use App\Filament\Resources\Shop\NotificationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNotifications extends ListRecords
{
    protected static string $resource = NotificationResource::class;

    protected ?string $maxContentWidth = '6xl';

    protected function getTitle(): string
    {
        return 'Уведомления';
    }

    protected function getActions(): array
    {
        return [];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [ 50, 100, 150 ];
    }
}
