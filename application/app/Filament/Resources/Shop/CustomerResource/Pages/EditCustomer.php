<?php

namespace App\Filament\Resources\Shop\CustomerResource\Pages;

use App\Events\Shop\EntityEvent;
use App\Filament\Resources\Shop\CustomerResource;
use App\Models\Shop\Customer;
use App\Services\CacheService;
use App\Services\Event\EventDto;
use App\Services\Event\EventManager;
use App\Services\Event\EventService;
use Exception;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\ActionGroup;
use Filament\Pages\Actions\DeleteAction;
use Filament\Pages\Actions\EditAction;
use Filament\Pages\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function afterSave(): void
    {
        event(new EntityEvent(
            Auth::user(),
            $this->getMountedActionFormModel(),
            EventManager::clientUpdated(),
        ));
    }

    protected function getRedirectUrl(): string
    {
        return CustomerResource::getUrl();
    }

    /**
     * @throws Exception
     */
    protected function getActions(): array
    {
        return [
//            Action::make('history')
//                ->label('История')
//                ->action('history')
//                ->modalHeading('История клиента')
//                ->modalContent(view('history.customer')),

            DeleteAction::make()
               //TODO ->visible(fn (Customer $record): bool => auth()->user()->can('delete', $record))
        ];
    }
}

