<?php

namespace App\Imports;

use App\Models\Shop\Customer;
use App\Models\Shop\Import;
use App\Models\Shop\Shop;
use App\Services\ModelHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\ImportFailed;

class CustomersImport implements ToModel, WithHeadingRow, ShouldQueue, WithChunkReading, WithEvents
{
    use RegistersEventListeners;

    private Shop $shop;
    private int $customerId;

    private int $rows = 0;
    private Import $import;

    public function __construct(Shop $shop, Import $import)
    {
        $this->shop = $shop;
        $this->import = $import;
        $this->customerId = ModelHelper::generateId(Customer::class, 'customer_id');
    }

    /**
     * @param array $row
     *
     * @return Model|Customer|null
     */
    public function model(array $row): Model|Customer|null
    {
        ++$this->customerId;
        ++$this->rows;

        return new Customer([
            'name'     => $row['name'] ?? 'as',
            'email'    => $row['email'] ?? null,
            'phone'    => $row['phone'] ?? null,
            'birthday' => $row['birthday'] ?? null,
            'inn'      => $row['inn'] ?? null,
            'kpp'      => $row['kpp'] ?? null,
            'rs'       => $row['rs'] ?? null,
            'type'     => (!empty($row['kpp']) || !empty($row['rs']) || !empty($row['inn'])) ? 2 : 1,

            'shop_id'     => $this->shop->id,
            'customer_id' => $this->customerId,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function(ImportFailed $event) {

                Log::error($event->getException());
            },
            AfterImport::class => function(AfterImport $event) {

                $this->import->count_imported = ++$this->rows;//TODO
                $this->import->is_completed = true;
                $this->import->save();
            },
        ];
    }

    public function rules(): array
    {
        return [
            'email' => 'email',
            'phone' => 'numeric',
            'name'  => 'size:100',
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function uniqueBy(): array//TODO
    {
        return ['email', 'shop_id'];
    }
}
