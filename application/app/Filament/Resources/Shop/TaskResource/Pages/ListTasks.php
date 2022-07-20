<?php

namespace App\Filament\Resources\Shop\TaskResource\Pages;

use App\Filament\Resources\Shop\OrderResource;
use App\Filament\Resources\Shop\TaskResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected static ?string $navigationGroup = 'Продажи';

    protected function getTitle(): string
    {
        return 'Задачи';
    }

    protected function getHeaderWidgets(): array
    {
        return TaskResource::getWidgets();
    }

    protected function getActions(): array
    {
        return [];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [25, 50, 100, 150];
    }

//    public function successTaskClick()
//    {
//        \Illuminate\Support\Facades\Log::info(__METHOD__, [json_encode($this)]);
//    }
}
