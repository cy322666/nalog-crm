<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),

            'name' => $this->faker->word(),

            'shop_id'  => Shop::all()->random()->id,

            'stock_id' => $this->faker->unique()->numberBetween(230000, 930000),
        ];
    }
}
