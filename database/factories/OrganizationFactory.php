<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization' => fake()->word(1),
            'city' => fake()->word(1),
            'address' => fake()->sentence(3),
            'allow_purchase' => fake()->boolean(50),
            'allow_borrow' => fake()->boolean(30),
            'allow_borrow_days' => fake()->randomDigit(),
        ];;
    }
}
