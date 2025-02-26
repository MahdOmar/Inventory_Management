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
           'designation' => fake()->word(),
           'quantity'    => fake()->numberBetween( 1,200),
           'price_a'     => fake()->numberBetween( 0,0),
           'price_v'     => fake()->numberBetween( 100,800),
           'category'    => fake()->randomElement(['plafond', 'elec'])
        ];
    }
}
