<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Events\Shop\EntityEvent;
use App\Filament\Resources\Shop\TaskResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EditTask extends EditRecord
{
    protected static string $resource = \App\Filament\Resources\TaskResource::class;

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

    protected function afterSave(): void
    {
        event(new EntityEvent(
            Auth::user(),
            $this->getMountedActionFormModel(),
            EventManager::taskUpdated(),
        ));
    }
}
