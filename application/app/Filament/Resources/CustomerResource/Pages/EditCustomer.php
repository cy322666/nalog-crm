<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Exception;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

use function event;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

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

