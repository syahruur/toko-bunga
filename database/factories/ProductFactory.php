<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(8),
            'price' => $this->faker->numberBetween(25000, 250000),
            'stock' => $this->faker->numberBetween(5, 50),
            'image' => 'https://picsum.photos/id/237/200/300',
            'is_available' => $this->faker->boolean(90),
        ];
    }
}
