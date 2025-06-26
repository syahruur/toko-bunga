<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => null, // Set in seeder
            'product_id' => null, // Set in seeder
            'quantity' => $this->faker->numberBetween(1, 3),
            'price' => $this->faker->numberBetween(25000, 250000),
        ];
    }
}
