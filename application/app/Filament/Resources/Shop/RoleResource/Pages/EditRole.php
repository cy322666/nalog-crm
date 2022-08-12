<?php

namespace App\Filament\Resources\Shop\RoleResource\Pages;

use App\Filament\Resources\Shop\RoleResource;
use App\Models\Role;
use App\Services\Roles\RoleManager;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    public Collection $permissions;

    protected static function refreshSelectAllStateViaEntities(\Closure $set, \Closure $get): void
    {
        $entitiesStates = collect(RoleManager::$resources)
//            ->when(config('filament-shield.entities.pages'), fn ($entities) => $entities->merge(FilamentShield::getPages()))
//            ->when(config('filament-shield.entities.widgets'), fn ($entities) => $entities->merge(FilamentShield::getWidgets()))
            ->when(config('filament-shield.entities.custom_permissions'), fn ($entities) => $entities->merge(static::getCustomEntities()))
            ->map(function ($entity) use ($get) {
                if (is_array($entity)) {
                    return (bool) $get($entity['resource']);
                }

                return (bool) $get($entity);
            });

        if ($entitiesStates->containsStrict(false) === false) {
            $set('select_all', true);
        }

        if ($entitiesStates->containsStrict(false) === true) {
            $set('select_all', false);
        }
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        Log::info(__METHOD__, [$this]);

        return $data;
    }

    protected static function refreshResourceEntityStateAfterHydrated(Model $record, \Closure $set, string $entity): void
    {
        $entities = $record->permissions->pluck('name')
            ->reduce(function ($roles, $role) {
                $roles[$role] = Str::afterLast($role, '_');

                return $roles;
            }, collect())
            ->values()
            ->groupBy(function ($item) {
                return $item;
            })->map->count()
            ->reduce(function ($counts, $role, $key) {
                if ($role > 1 && $role == count(config('filament-shield.permission_prefixes.resource'))) {
                    $counts[$key] = true;
                } else {
                    $counts[$key] = false;
                }

                return $counts;
            }, []);

        // set entity's state if one are all permissions are true
        if (Arr::exists($entities, $entity) && Arr::get($entities, $entity)) {
            $set($entity, true);
        } else {
            $set($entity, false);
            $set('select_all', false);
        }
    }

    protected static function getCustomEntities(): ?Collection
    {
        $resourcePermissions = collect();
        collect(RoleManager::$resources)->each(function ($entity) use ($resourcePermissions) {
            collect(config('filament-shield.permission_prefixes.resource'))->map(function ($permission) use ($resourcePermissions, $entity) {
                $resourcePermissions->push((string) Str::of($permission.'_'.$entity['resource']));
            });
        });

        $entitiesPermissions = $resourcePermissions
//            ->merge(FilamentShield::getPages())
//            ->merge(FilamentShield::getWidgets())
            ->values();

        return \App\Models\Permission::whereNotIn('name', $entitiesPermissions)->pluck('name');
    }

//    protected function afterSave($data): void
//    {
//        Log::info(__METHOD__, $data);
//
//        return $data;
//        $permissionModels = collect();
//        $this->permissions->each(function ($permission) use ($permissionModels) {
//            $permissionModels->push(Permission::firstOrCreate(
//                ['name' => $permission],
//                ['guard_name' => config('filament.auth.guard')]
//            ));
//        });
//
//        $this->record->syncPermissions($permissionModels);
//    }
}
