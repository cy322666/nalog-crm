<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'is_read'   => rand(true, false),
            'is_pushed' => rand(true, false),

            'level' => 'info',

            'notifiable_type' => User::class,

            'title' => $this->faker->words(3, true),
            'message' => $this->faker->words(5, true),

            'link' => env('APP_URL'),

            'shop_id' => Shop::all()->random()->id,

            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month'),
        ];
    }
}
