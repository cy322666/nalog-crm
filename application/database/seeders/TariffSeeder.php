<?php

namespace Database\Seeders;

use App\Models\Shop\Tariff;
use Illuminate\Database\Seeder;

class TariffSeeder extends Seeder
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
            'active' => true,
            'name' => 'Базовый',
            'price' => 500,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'active' => false,
            'name' => 'Расширенный',
            'price' => 1000,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'active' => false,
            'name' => 'Профессиональный',
            'price' => 1500,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Тестовый',
            'active' => true,
            'price' => 0,
        ]];

        foreach ($data as $item) {

            Tariff::query()->create($item);
        }

        $this->command->info('Тарифы созданы');
    }
}
