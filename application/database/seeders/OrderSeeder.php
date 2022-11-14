<?php

namespace Database\Seeders;

use App\Models\Shop\Order;
use App\Models\Shop\OrderLostReasons;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::factory()->count(500)->create();

        $latest = Order::query()->latest()->first();

        $orderId = $latest ? $latest->order_id++ : 1;

        foreach ($orders as $order) {

            $shop = $order->shop;

            try {
                $order->shop_customer_id = $shop->customers()->get()->random()->id;
                $order->closed = $order->status_id == 3 || $order->status_id == 2;
                $order->order_id = $orderId;
                $order->lost_reasons_id = $order->status_id == 3 ? OrderLostReasons::all()->random()->id : null;
                $order->responsible_id = $shop->users->random()->id;
                $order->creator_id = $shop->users->random()->id;
                $order->save();

                $orderId++;

            } catch (\Exception $exception) {

                dd($exception->getMessage(), $shop->users->toArray(), $shop);
            }
        }
    }
}
