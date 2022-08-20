<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Product;
use App\Models\Shop\Shop;
use App\Models\User;
use App\Services\Helpers\ModelHelper;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Product::class;

    /**
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,

            'description' => $this->faker->realText(),

            'qty' => rand(0, 20),

            'security_stock' => rand(0, 20),

            'old_price' => $this->faker->randomFloat(2, 100, 500),
            'price' => $this->faker->randomFloat(2, 80, 400),

            'cost' => $this->faker->randomFloat(2, 50, 200),

            'shop_id' => Shop::all()->random()->id,

            'product_id' => random_int(200000, 999999),

//            'creator_id' => User::all()->random()->id,

//            'featured' => $this->faker->boolean(),
//            'is_visible' => $this->faker->boolean(),

//            'type' => $this->faker->randomElement(['deliverable', 'downloadable']),
//            'published_at' => $this->faker->dateTimeBetween('-1 year', '+1 year'),

            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month'),
        ];
    }

//    public function configure(): ProductFactory
//    {
//        return $this->afterCreating(function (Product $product) {
//            $imageUrl = 'https://picsum.photos/200';
//            $product
//                ->addMediaFromUrl($imageUrl)
//                ->toMediaCollection('product-images');
//        });
//    }
}
