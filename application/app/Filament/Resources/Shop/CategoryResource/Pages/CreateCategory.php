<?php

namespace App\Filament\Resources\Shop\CategoryResource\Pages;

use App\Filament\Resources\Shop\CategoryResource;
use App\Models\Shop\Category;
use App\Services\CacheService;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function handleRecordCreation(array $data): Category
    {
        $data['category_id'] = rand(100000, 999999);//TODO переместить в форму
        $data['shop_id'] = CacheService::getAccountId();//TODO hidden field

        return static::getModel()::create($data);
    }
}
