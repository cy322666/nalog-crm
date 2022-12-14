<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Events\Shop\EntityEvent;
use App\Filament\Resources\ProductResource;
use App\Services\Event\EventManager;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

use function event;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        return ProductResource::getUrl();
    }

    protected function afterSave(): void
    {
        event(new EntityEvent(
            Auth::user(),
            $this->getMountedActionFormModel(),
            EventManager::productUpdated(),
        ));
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
