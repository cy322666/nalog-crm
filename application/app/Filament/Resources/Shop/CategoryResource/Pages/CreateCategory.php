<?php

namespace App\Filament\Resources\Shop\CategoryResource\Pages;

use App\Events\Shop\EntityEvent;
use App\Filament\Resources\Shop\CategoryResource;
use App\Models\Shop\Category;
use App\Services\CacheService;
use App\Services\Event\EventManager;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return CategoryResource::getUrl();
    }
}
