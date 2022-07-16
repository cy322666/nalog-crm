<?php

namespace App\Filament\Resources\Shop\TaskResource\Pages;

use App\Filament\Resources\Shop\TaskResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

//    protected function handleRecordUpdate(Model $record, array $data): Model
//    {
//        \Illuminate\Support\Facades\Log::info(__METHOD__, $data);
//
//        return $record;
//    }
}
