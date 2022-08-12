<?php

namespace App\Imports;

use App\Models\Shop\Customer;
use App\Models\Shop\Import;
use App\Models\Shop\Shop;
use App\Services\Helpers\ModelHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\ImportFailed;

class CustomersImport implements ToCollection, WithHeadingRow, ShouldQueue, WithChunkReading, WithEvents
{
    use RegistersEventListeners;

    private Shop $shop;
    private int $customerId;

    private int $rows = 0;
    private Import $import;

    public function __construct(Shop $shop, Import $import)
    {
        sleep(3);

        $this->shop = $shop;
        $this->import = $import;
        $this->customerId = ModelHelper::generateId(Customer::class, 'customer_id');
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            //TODO валидация, репорты о проблемах

//            if (!empty($row['email']) || !empty($row['phone'])) {

                ++$this->customerId;
                ++$this->rows;

                $customer = Customer::query()
                    ->where('shop_id', $this->shop->id)
                    ->where('email', trim($row['email']))
                    ->orWhere('phone', trim($row['phone']))
                    ->first();

                if (!$customer) {

                    $customer = new Customer();
                }

                $customer->fill([
                    'name'     => $row['name'] ?? "Клиент #{$this->customerId}",
                    'email'    => trim($row['email']) ?? null,
                    'phone'    => ModelHelper::clearPhone(trim($row['phone'])) ?? null,
                    'birthday' => $row['birthday'] ?? null,
                    'inn'      => trim($row['inn']) ?? null,
                    'kpp'      => trim($row['kpp']) ?? null,
                    'rs'       => trim($row['rs']) ?? null,
                    'type'     => (!empty($row['kpp']) || !empty($row['rs']) || !empty($row['inn'])) ? 2 : 1,

                    'shop_id'     => $this->shop->id,
                    'customer_id' => $this->customerId,
                ]);
                $customer->save();

                Log::info(__METHOD__.' customer id '.$customer->id);
//            }
        }
    }

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function(ImportFailed $event) {

                Log::error($event->getException());
            },
            AfterImport::class => function(AfterImport $event) {

                sleep(3);

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
//            'phone' => 'numeric',
            'name'  => 'size:100',
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }

//    public function uniqueBy(): array//TODO
//    {
//        return ['email', 'shop_id'];
//    }
}
