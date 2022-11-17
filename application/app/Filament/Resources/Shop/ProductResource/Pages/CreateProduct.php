<?php

namespace App\Filament\Resources\Shop\ProductResource\Pages;

use App\Events\Shop\EntityEvent;
use App\Filament\Resources\Shop\ProductResource;
use App\Services\Event\EventManager;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        return ProductResource::getUrl();
    }
}
