<?php

namespace Database\Seeders;

use App\Models\Shop\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    public function run()
    {
        $data = [[
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Новый',
            'status_id' => 101,
            'shop_id' => 0,
            'type' => 'new',
            'is_system' => true,
            'order' => 100,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Выиграно',
            'status_id' => 102,
            'shop_id' => 0,
            'type' => 'success',
            'is_system' => true,
            'order' => 900,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Потеряно',
            'status_id' => 103,
            'shop_id' => 0,
            'type' => 'lost',
            'is_system' => true,
            'order' => 800,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'В работе',
            'status_id' => rand(234523, 992333),
            'shop_id' => 0,
            'type' => 'work',
            'is_system' => false,
            'order' => 110,
        ]];

        foreach ($data as $item) {

            OrderStatus::query()->create($item);
        }

        $this->command->info('Статусы заказов созданы');
    }
}
