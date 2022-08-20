<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
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
            'name' => 'Просмотр заказов',
            'slug' => 'view_orders',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Создание заказов',
            'slug' => 'create_orders',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Удаление заказов',
            'slug' => 'delete_orders',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Обновление заказов',
            'slug' => 'update_orders',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Просмотр товаров',
            'slug' => 'view_products',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Создание товаров',
            'slug' => 'create_products',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Удаление товаров',
            'slug' => 'delete_products',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Обновление товаров',
            'slug' => 'update_products',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Просмотр платежей',
            'slug' => 'view_payments',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Создание платежей',
            'slug' => 'create_payments',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Удаление платежей',
            'slug' => 'delete_payments',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Обновление платежей',
            'slug' => 'update_payments',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Просмотр категорий',
            'slug' => 'view_categories',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Создание категорий',
            'slug' => 'create_categories',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Удаление категорий',
            'slug' => 'delete_categories',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Обновление категорий',
            'slug' => 'update_categories',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Просмотр складов',
            'slug' => 'view_stocks',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Создание складов',
            'slug' => 'create_stocks',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Удаление складов',
            'slug' => 'delete_stocks',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Обновление складов',
            'slug' => 'update_stocks',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Просмотр клиентов',
            'slug' => 'view_clients',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Создание клиентов',
            'slug' => 'create_clients',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Удаление клиентов',
            'slug' => 'delete_clients',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Обновление клиентов',
            'slug' => 'update_clients',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Удаление задач',
            'slug' => 'delete_tasks',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Обновление задач',
            'slug' => 'update_tasks',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Создание задач',
            'slug' => 'create_tasks',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Просмотр  задач',
            'slug' => 'view_tasks',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Удаление пользователей',
            'slug' => 'delete_users',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Обновление пользователей',
            'slug' => 'update_users',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Создание пользователей',
            'slug' => 'create_users',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Просмотр пользователей',
            'slug' => 'view_users',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Удаление ролей',
            'slug' => 'delete_roles',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Обновление ролей',
            'slug' => 'update_roles',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Создание ролей',
            'slug' => 'create_roles',
        ], [
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Просмотр ролей',
            'slug' => 'view_roles',
        ]];

        foreach ($data as $item) {

            Permission::query()->create($item);
        }

        foreach (Role::all() as $role) {

            if ($role->name == 'root') continue;

            if ($role->name == 'Администратор') {

                $permissions = Permission::all();
            }

            if ($role->name == 'Менеджер') {

                $permissions = Permission::query()
                    ->where('slug', 'like', "%view%")
                    ->orWhere('slug', 'like', "%create%")
                    ->orWhere('slug', 'like', "%update%")
                    ->get();
            }

            foreach ($permissions as $permission) {

                $role->permissions()->attach($permission->id);
            }

            $this->command->info('Права созданы + с ролями связаны');
        }
    }
}
