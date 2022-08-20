<?php

namespace Database\Seeders;

use App\Models\Shop\OrderLostReasons;
use Illuminate\Database\Seeder;

class OrderLostReasonsSeeder extends Seeder
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
            'name' => 'Дорого',
            'reason_id' => 301,
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Потерялся(лась)',
            'reason_id' => 302,
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Не интересно',
            'reason_id' => 303,
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Тест',
            'reason_id' => 304,
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Дубль',
            'reason_id' => 305,
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Передумал(а)',
            'reason_id' => 306,
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Не целевой',
            'reason_id' => 307,
            'shop_id' => 0,
            'is_system' => true,
        ]];

        foreach ($data as $item) {

            OrderLostReasons::query()->create($item);
        }

        $this->command->info('Причины отказов заказов созданы');
    }
}
