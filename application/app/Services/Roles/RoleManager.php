<?php

namespace App\Services\Roles;

use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\EmployeeResource;
use App\Filament\Resources\PaymentResource;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\Shop\OrderResource;
use App\Filament\Resources\Shop\RoleResource;
use Illuminate\Support\Facades\Auth;

class RoleManager
{
    public static array $resources = [[
            'model'    => 'orders',
            'resource' => OrderResource::class,
            'label'    => 'Заказы',
            'permissions' => ['view_orders', 'create_orders', 'delete_orders', 'update_orders'],
            'titles' => [
                'view_orders'   => 'Просмотр',
                'create_orders'  => 'Создание',
                'delete_orders' => 'Удаление',
                'update_orders' => 'Обновление'
            ],
        ], [
            'model'    => 'products',
            'resource' => ProductResource::class,
            'label'    => 'Товары',
            'permissions' => ['view_products', 'create_products', 'delete_products', 'update_products'],
            'titles' => [
                'view_products'   => 'Просмотр',
                'create_products'  => 'Создание',
                'delete_products' => 'Удаление',
                'update_products' => 'Обновление'
            ],
        ], [
            'model'    => 'payments',
            'resource' => PaymentResource::class,
            'label'    => 'Платежи',
            'permissions' => ['view_payments', 'create_payments', 'delete_payments', 'update_payments'],
            'titles' => [
                'view_payments'   => 'Просмотр',
                'create_payments'  => 'Создание',
                'delete_payments' => 'Удаление',
                'update_payments' => 'Обновление'
            ],
        ], [
            'model'    => 'categories',
            'resource' => CategoryResource::class,
            'label'    => 'Категории',
            'permissions' => ['view_categories', 'create_categories', 'delete_categories', 'update_categories'],
            'titles' => [
                'view_categories'   => 'Просмотр',
                'create_categories' => 'Создание',
                'delete_categories' => 'Удаление',
                'update_categories' => 'Обновление'
            ],
        ],
        [
            'model'    => 'clients',
            'resource' => CustomerResource::class,
            'label'    => 'Клиенты',
            'permissions' => ['view_clients', 'create_clients', 'delete_clients', 'update_clients'],
            'titles' => [
                'view_clients'   => 'Просмотр',
                'create_clients' => 'Создание',
                'delete_clients' => 'Удаление',
                'update_clients' => 'Обновление'
            ],
        ], [
//            'model'    => 'tasks',
//            'resource' => TaskResource::class,
//            'label'    => 'Задачи',
//            'permissions' => ['view_tasks', 'create_tasks', 'delete_tasks', 'update_tasks'],
//            'titles' => [
//                'view_tasks'   => 'Просмотр',
//                'create_tasks'  => 'Создание',
//                'delete_tasks' => 'Удаление',
//                'update_tasks' => 'Обновление'
//            ],
        ], [
            'model'    => 'users',
            'resource' => EmployeeResource::class,
            'label'    => 'Сотрудники',
            'permissions' => ['view_users', 'create_users', 'delete_users', 'update_users'],
            'titles' => [
                'view_users'   => 'Просмотр',
                'create_users' => 'Создание',
                'delete_users' => 'Удаление',
                'update_users' => 'Обновление'
            ],
        ], [
            'model'    => 'roles',
            'resource' => RoleResource::class,
            'label'    => 'Роли и права',
            'permissions' => ['view_roles', 'create_roles', 'delete_roles', 'update_roles'],
            'titles' => [
                'view_roles'   => 'Просмотр',
                'create_roles'  => 'Создание',
                'delete_roles' => 'Удаление',
                'update_roles' => 'Обновление'
            ],
        ]];

    public static array $pages = [];

    private static array $actions = [];

    public static function map(): string
    {
//        $roleName = Auth::user()
//            ->roles()
//            ->where('shop_id', $shop->id)
//            ->first()
//            ->name ?? 'root';//TODO

        return match ('root') {
            'root' => 'root',
            'Администратор', 'Админ' => 'admin',
            default => 'manager',
        };
    }
}
