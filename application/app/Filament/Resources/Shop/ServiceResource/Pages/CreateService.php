<?php

namespace App\Filament\Resources\Shop\ServiceResource\Pages;

use App\Filament\Resources\Shop\ServiceResource;
use App\Models\Shop\Service;
use App\Services\CacheService;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

//    protected function handleRecordCreation(array $data): Service
//    {
//        $data['shop_id'] = CacheService::getAccountId();
//
//        return static::getModel()::create($data);
//    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
