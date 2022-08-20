<?php

namespace Database\Factories\Shop;

use App\Models\Shop\PaymentMethod;
use App\Models\Shop\PaymentStatus;
use App\Models\Shop\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->randomFloat(2, 80, 400),

            //TODO 'provider_id'

            'method_id' => PaymentMethod::all()->random()->id,

            'method' => 1,//TODO del

            'order_id' => 1,

            'name' => $this->faker->word(),

            'status_id' => PaymentStatus::all()->random()->id,

            'shop_id' => Shop::all()->random()->id,

            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month'),
        ];
    }
}
