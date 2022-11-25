<?php

namespace Database\Seeders;

use App\Models\Shop\Address;
use App\Models\Shop\Brand;
use App\Models\Shop\Category as ShopCategory;
use App\Models\Shop\Comment;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\OrderProduct;
use App\Models\Shop\Payment;
use App\Models\Shop\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear images
        Storage::deleteDirectory('public');

        //php artisan db:seed --class=DatabaseSeeder

        $this->call([

            //справочники:

            LaraworldSeeder::class,   //валюты, зоны, языки
            OrderStatusSeeder::class, //статусы заказов
            OrderSourceSeeder::class, //источники заказов
            OrderLostReasonsSeeder::class, //причины отказа
            PaymentStatusSeeder::class, //статусы платежей
            PaymentMethodsSeeder::class, //способы оплаты

            //юзеры права и шопы

            TariffSeeder::class, // тарифы
            RoleSeeder::class, // роли
            PermissionsSeeder::class, // права + связка с ролями
            ShopSeeder::class, // шопы + роли для них
            UserSeeder::class, // юзеры + релейшены к шопам + права и роли

            CustomerSeeder::class, // клиенты
            StockSeeder::class, // склады

            ProductSeeder::class, // товары + связи со складами

            OrderSeeder::class, // заказы + связи с продуктами
            PaymentSeeder::class, // оплаты

            ServiceSeeder::class, // услуги + связи с заказами
            CategorySeeder::class, // категории + связи с продуктами

//            TaskSeeder::class, // задачи


        //уведомления

        ]);

//            CommentSeeder::class,
        //комменты?
        //события??
    }
}
