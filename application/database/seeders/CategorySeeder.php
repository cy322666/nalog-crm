<?php

namespace Database\Seeders;

use App\Models\Shop\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::factory()->count(20)->create();

        $latest = Category::query()->latest()->first();

        $categoryId = $latest && $latest->category_id !== null ? $latest->category_id++ : 1;

        foreach ($categories as $category) {

            $shop = $category->shop;

            $category->category_id = $categoryId;
            $category->creator_id = $shop->users->random()->id;
            $category->save();
//TODO удалить created_at + updated_at in pivot table
            $categoryId++;

            foreach ($shop->products as $product) {

                if (rand(0,1) == 1) {

                    $category->products()->attach($product->id);
                }
            }
        }
    }
}
