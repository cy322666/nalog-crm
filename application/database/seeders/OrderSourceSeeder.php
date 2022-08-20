<?php

namespace Database\Seeders;

use App\Models\Shop\OrderSource;
use Illuminate\Database\Seeder;

class OrderSourceSeeder extends Seeder
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
            'name' => 'Инстаграм',
            'source_id' => 201,
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'ВКонтакте',
            'source_id' => 202,
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Рекомендация',
            'source_id' => 203,
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Ютуб',
            'source_id' => 204,
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Авито',
            'source_id' => 205,
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Телеграм',
            'source_id' => 206,
            'shop_id' => 0,
            'is_system' => true,
        ]];

        foreach ($data as $item) {

            OrderSource::query()->create($item);
        }

        $this->command->info('Источники заказов созданы');
    }
}
