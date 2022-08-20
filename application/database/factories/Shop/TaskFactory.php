<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(4, true),

            'description' => $this->faker->realText,

            'model_type' => rand(1,2),

            'shop_id' => Shop::all()->random()->id,

            'responsible_id' => 1,
            'model_id' => 1,
            'task_id' => 1,
            'is_failed' => false,

            'execute_at' => $this->faker->dateTimeBetween('-1 year'),
            'execute_to' => $this->faker->dateTimeBetween('-1 year'),

            'created_at' => $this->faker->dateTimeBetween('-1 year'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year'),
        ];
    }
}
