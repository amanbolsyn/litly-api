<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
               'fullname' => fake()->name(), 
               'biography' => fake()->paragraph(4), 
               'date_of_birth' => fake()->dateTimeBetween('-150 years', '-50 years'),
               'date_of_death' => fake()->dateTimeBetween('-50 years', 'now'), 
        ];
        
    }
}
