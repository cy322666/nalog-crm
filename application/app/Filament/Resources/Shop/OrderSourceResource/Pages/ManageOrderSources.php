<?php

namespace App\Filament\Resources\Shop\OrderSourceResource\Pages;

use App\Filament\Resources\Shop\OrderSourceResource;
use Exception;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageOrderSources extends ManageRecords
{
    protected static string $resource = OrderSourceResource::class;

    /**
     * @throws Exception
     */
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
