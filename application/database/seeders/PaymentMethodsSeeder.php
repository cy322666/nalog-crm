<?php

namespace Database\Seeders;

use App\Models\Shop\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Наличные',
            'method_id' => 401,
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Картой',
            'method_id' => 402,
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Qiwi',
            'method_id' => 403,
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Почта',
            'method_id' => 404,
            'shop_id' => 0,
            'is_system' => true,
        ]];

        foreach ($data as $item) {

            PaymentMethod::query()->create($item);
        }

        $this->command->info('Методы оплаты платежей созданы');
    }
}
