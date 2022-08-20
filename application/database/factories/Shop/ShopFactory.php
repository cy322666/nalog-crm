<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ShopFactory extends Factory
{
    protected $model = Shop::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'created_at' => $this->faker->dateTimeBetween('-1 year'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year'),

            'name' => $this->faker->unique()->word(),

//            'active'  => $this->faker->boolean(),
            'shop_id'   => $this->faker->unique()->numberBetween(230000, 930000),
            'tariff_id' => 1,

            'expired_at' => $this->faker->dateTimeBetween('-1 year', '+1 year'),

            'uuid' => Uuid::uuid4(),
        ];
    }
}
