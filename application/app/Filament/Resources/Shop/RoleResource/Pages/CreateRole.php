<?php

namespace App\Filament\Resources\Shop\RoleResource\Pages;

use App\Filament\Resources\Shop\RoleResource;
use App\Services\CacheService;
use App\Services\Roles\RoleManager;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    public Collection $permissions;

//    protected function afterCreate(): void
//    {
////        $this->record->detach();
//
//        foreach ($this->data as $key => $datum) {
//
//            if ($datum === true) {
//
//                $this
//                    ->record
//                    ->permissions()
//                    ->attach(
//                        Permission::query()
//                            ->where('slug', $key)
//                            ->first()
//                            ->id
//                    );
//            }
//        }
//    }
}
