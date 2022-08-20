<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
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
            'name' => 'root',
            'slug' => 'root',
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Администратор',
            'slug' => 'admin',
            'shop_id' => 0,
            'is_system' => true,
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Менеджер',
            'slug' => 'manager',
            'shop_id' => 0,
            'is_system' => true,
        ]];

        foreach ($data as $item) {

            Role::query()->create($item);
        }

        $this->command->info('Роли созданы');
    }
}
