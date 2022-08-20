<?php

namespace Database\Seeders;

use App\Models\Shop\Shop;
use App\Models\Shop\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stocks = Stock::factory()
            ->count(10)
            ->create();

        foreach ($stocks as $stock) {

            if (1 == rand(0,1)) {

                $stock->parent_stock_id = Shop::query()
                    ->find($stock->shop_id)
                        ->stocks
                        ?->random()
                            ->id;

                $stock->save();
            }
        }
    }
}
