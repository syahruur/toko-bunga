<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null, // Set in seeder
            'total_amount' => $this->faker->numberBetween(100000, 500000),
            'status' => $this->faker->randomElement(['pending', 'completed', 'processing', 'cancelled']),
            'shipping_address' => $this->faker->address(),
            'recipient_name' => $this->faker->name(),
            'recipient_phone' => $this->faker->phoneNumber(),
            'notes' => $this->faker->optional()->sentence(6),
        ];
    }
}
