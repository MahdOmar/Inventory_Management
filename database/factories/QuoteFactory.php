<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client' => fake()->name(),
            'phone'     => fake()->phoneNumber(),
            'total'     => fake()->numberBetween( 0,0),
            'status'    => fake()->randomElement(['pending', 'pending'])
        ];
    }
}
