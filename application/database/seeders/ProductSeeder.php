<?php

namespace Database\Seeders;

use App\Models\Shop\Product;
use App\Models\Shop\Shop;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::factory()->count(100)->create();

        $latest = Product::query()->latest()->first();

        $sku     = ++$latest->sku ? ++$latest->sku : 2;
        $barcode = ++$latest->barcode ? ++$latest->barcode : 1;

        foreach ($products as $product) {

            $product->sku = $sku;
            $product->barcode = $barcode;
            $product->creator_id = $product->shop->users->random()->id;
            $product->save();

            $sku++;
            $barcode++;

            foreach ($product->shop->stocks as $stock) {

                if (rand(0, 1) == 1) {

                    $stock->products()->attach($product->id, ['count' => rand(1, 20)]);
                }
            }
        }
    }
}
