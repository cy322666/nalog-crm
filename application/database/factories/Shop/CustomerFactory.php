<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Customer;
use App\Models\Shop\Shop;
use App\Services\Helpers\ModelHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Customer::class;

    /**
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'name'  => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => ModelHelper::clearPhone($this->faker->phoneNumber()),
            'birthday'   => $this->faker->dateTimeBetween('-35 years', '-18 years'),
//            'gender'     => $this->faker->randomElement(['male', 'female']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),

            'shop_id' => Shop::all()->random()->id,

            'customer_id' => random_int(200000, 999999),
        ];
    }
}
