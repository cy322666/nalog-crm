<?php

namespace Database\Seeders;

use App\Models\Shop\Customer;
use App\Models\Shop\Shop;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = Customer::factory(500)->create();

        foreach ($customers as $customer) {

            $customer->type = rand(1,2);
            $customer->shop_id = Shop::query()->get()->random()->id;

            if ($customer->type == 2) {

                $customer->inn = rand(20000,30000);
                $customer->kpp = rand(20000,30000);
                $customer->rs  = rand(20000,30000);
            }

            $shop = Shop::query()->find($customer->shop_id);

            if ($shop->users->count() > 0) {

                $customer->creator_id = $shop->users?->random()->id;
            }
            $customer->save();
        }
    }
}
