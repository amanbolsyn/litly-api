<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Organization;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(2),
            'isbn' => fake()->isbn13(),
            'description' => fake()->paragraph(7),
            'publication_year' => fake()->dateTimeBetween('-100 years', 'now'),
            'publisher_id' => Publisher::inRandomOrder()->value('id'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($book) {

            $categories = Category::inRandomOrder()
                ->limit(rand(1, 3))
                ->pluck('id');
            $book->categories()->attach($categories);

            $authors = Author::inRandomOrder()
                ->limit(rand(1, 2))
                ->pluck('id');
            $book->authors()->attach($authors);

            $organizations = Organization::inRandomOrder()
                ->limit(rand(1, 5))
                ->pluck('id');
            $book->organizations()->attach(
                $organizations->mapWithKeys(function ($id) {
                    return [
                        $id => ['stock' => fake()->numberBetween(1, 10)]
                    ];
                })
            );

            $bookCollections = Collection::inRandomOrder()
                ->limit(rand(1, 6))
                ->pluck('id');
            $book->collections()->attach($bookCollections);
        });
    }
}
