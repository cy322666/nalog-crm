<?php

namespace Database\Seeders;

use App\Models\Shop\PaymentStatus;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
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
            'name' => 'Новый',
            'status_id' => 201,
            'shop_id' => 0,
            'type' => 'new',
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Оплачен',
            'status_id' => 202,
            'shop_id' => 0,
            'type' => 'success',
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Отменен',
            'status_id' => 203,
            'shop_id' => 0,
            'type' => 'lost',
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Отправлен',
            'status_id' => 204,
            'shop_id' => 0,
            'type' => 'work',
            'is_system' => true,
        ]];

        foreach ($data as $item) {

            PaymentStatus::query()->create($item);
        }

        $this->command->info('Статусы платежей заказов созданы');
    }
}
