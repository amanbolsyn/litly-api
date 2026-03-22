<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
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
            'book_id' => Book::inRandomOrder()->value('id'),
            'cart_id' => Cart::inRandomOrder()->value('id'),
            'order_type' => fake()->randomElement(Order::ORDER_TYPE),
            'status' => fake()->randomElement(Order::STATUS_LEVELS),
            'due_date' => fake()->dateTimeBetween('now', '+5 days'),
            'returned_at' => fake()->dateTimeBetween('2022-03-12', '2026-03-12')
        ];
    }
}
