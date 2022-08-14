<?php

namespace App\Filament\Resources\Shop\CategoryResource\Pages;

use App\Events\Shop\EntityEvent;
use App\Filament\Resources\Shop\CategoryResource;
use App\Filament\Resources\Shop\OrderResource;
use App\Services\Event\EventManager;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return CategoryResource::getUrl();
    }

    protected function afterSave(): void
    {
        event(new EntityEvent(
            Auth::user(),
            $this->getMountedActionFormModel(),
            EventManager::categoryUpdated(),
        ));
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make()
                ->after(function () {
                    event(new EntityEvent(
                        Auth::user(),
                        $this->getMountedActionFormModel(),
                        EventManager::categoryDeleted(),
                    ));
                })
        ];
    }
}
