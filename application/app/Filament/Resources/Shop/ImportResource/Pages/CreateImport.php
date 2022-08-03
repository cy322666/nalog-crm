<?php

namespace App\Filament\Resources\Shop\ImportResource\Pages;

use App\Filament\Resources\Shop\ImportResource;
use App\Imports\CustomersImport;
use App\Models\Shop\Import;
use App\Models\Shop\Shop;
use App\Services\CacheService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class CreateImport extends CreateRecord
{
    protected static string $resource = ImportResource::class;

    protected function afterCreate(): void
    {
        $filePath = Config::get('crm.storage_disk').'/'.$this->record->name;

        $heads  = (new HeadingRowImport(1))->toArray($filePath)[0][0];
        $values = (new HeadingRowImport(2))->toArray($filePath)[0][0];

        for ($i = 0; $i < count($heads); $i++) {

            $this->record
                ->settings()
                ->create([
                    'column' => $heads[$i],
                    'key' => $values[$i],
                    'import_id' => 1223,
                    'entity_type' => $this->record->type,
                ]);
        }

        $this->record->count_rows = count(
            Excel::toArray(
                new CustomersImport(
                    new Shop(),
                    new Import(),//TODO ???
                ), $filePath)[0]);
        $this->record->shop_id = CacheService::getAccountId();
        $this->record->save();
    }
}
