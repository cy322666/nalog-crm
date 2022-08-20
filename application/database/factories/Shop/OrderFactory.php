<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Order;
use App\Models\Shop\OrderSource;
use App\Models\Shop\OrderStatus;
use App\Models\Shop\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,

            'price' => $this->faker->randomFloat(2, 100, 2000),

            'description' => $this->faker->realText(),

            'shop_id' => Shop::all()->random()->id,

            'status_id' => OrderStatus::all()->random()->id,

            'source_id' => OrderSource::all()->random()->id,

            'pay_parts' => rand(1,5),

//            'status' => $this->faker->randomElement(['new', 'processing', 'shipped', 'delivered', 'cancelled']),
//            'shipping_price' => $this->faker->randomFloat(2, 100, 500),
//            'shipping_method' => $this->faker->randomElement(['free', 'flat', 'flat_rate', 'flat_rate_per_item']),
//            'notes' => $this->faker->realText(100),

            'created_at' => $this->faker->dateTimeBetween('-1 year'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month'),
        ];
    }

//    public function configure(): Factory
//    {
//        return $this->afterCreating(function (Order $order) {
//            $order->address()->save(OrderAddressFactory::new()->make());
//        });
//    }
}
