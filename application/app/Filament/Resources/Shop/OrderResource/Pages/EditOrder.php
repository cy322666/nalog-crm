<?php

namespace App\Filament\Resources\Shop\OrderResource\Pages;

use App\Events\Shop\EntityEvent;
use App\Filament\Resources\Shop\OrderResource;
use App\Models\Shop\Order;
use App\Services\Event\EventManager;
use Filament\Pages\Actions\CreateAction;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        //TODO бюджет пересчитывает?
//        $total = 0;
//        foreach ($data['items'] as $item) {
//            $total += $item['unit_price'] * $item['qty'];
//        }
//
//        $data['total_price'] = $total;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return OrderResource::getUrl();
    }

    protected function afterSave(): void
    {
//        event(new EntityEvent(
//            Auth::user(),
//            $this->getMountedActionFormModel(),
//            EventManager::orderUpdated(),
//        ));
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make()
                ->after(function () {
//                    event(new EntityEvent(
//                        Auth::user(),
//                        $this->getMountedActionFormModel(),
//                        EventManager::orderDeleted(),
//                    ));
                })
        ];
    }
}
