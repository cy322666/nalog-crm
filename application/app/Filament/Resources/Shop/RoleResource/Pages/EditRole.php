<?php

namespace App\Filament\Resources\Shop\RoleResource\Pages;

use App\Filament\Resources\Shop\RoleResource;
use App\Models\Role;
use App\Models\Shop\Shop;
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

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    public Collection $permissions;

    //до отрисовки при просмотре
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    //до сохранения
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->record->detachPermissions();

        $dataArr = $data;

        unset($dataArr['id']);
        unset($dataArr['name']);
        unset($dataArr['shop_id']);
        unset($dataArr['created_at']);
        unset($dataArr['updated_at']);

        foreach ($dataArr as $key => $value) {

            if ($value == true) {

                try {
                    $this->record
                        ->permissions()
                        ->attach(
                            \App\Models\Permission::query()
                                ->whereSlug($key)
                                ->first()
                                ->id
                        );

                    Log::info(__METHOD__ . ' прикреплено : ' . $key);

                } catch (\Exception $exception) {

                    Log::info(__METHOD__ . ' нет по слагу : ' . $key);
                }
            }
        }

        return $data;
    }

    //определенные сущности
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

    protected function getActions(): array
    {
        return [
            Actions\Action::make('index')
                ->label('Все роли')
                ->url(RoleResource::getUrl()),
        ];
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
