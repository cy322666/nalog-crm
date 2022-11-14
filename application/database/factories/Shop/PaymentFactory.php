<?php

namespace Database\Factories\Shop;

use Akaunting\Money\Currency;
use App\Models\Shop\Payment;
use App\Models\Shop\PaymentMethod;
use App\Models\Shop\PaymentProvider;
use App\Models\Shop\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        $shop = Shop::all()->random();

        return [
            'name' => $this->faker->word(),
            'shop_id' => $shop->id,
            'order_id' => $shop->orders->random()->id,
            'payed' => (bool)rand(0, 1),
            'creator_id' => $shop->users->random()->id,
//            'reference' => 'PAY' . $this->faker->unique()->randomNumber(6),
//            'currency' => $this->faker->randomElement(collect(Currency::getCurrencies())->keys()),
            'amount' => $this->faker->randomFloat(2, 100, 2000),
//            'provider_id' => PaymentProvider::all()->random()->id ?? null,
            'method_id'   => PaymentMethod::all()->random()->id ?? null,
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
//            'lost_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}
