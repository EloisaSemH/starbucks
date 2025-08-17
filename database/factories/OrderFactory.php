<?php

namespace Database\Factories;

use App\Infrastructure\Persistence\Eloquent\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Persistence\Eloquent\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total_cents' => $this->faker->numberBetween(100, 1000),
            'paid_cents' => $this->faker->numberBetween(100, 1000),
            'change_cents' => $this->faker->numberBetween(100, 1000),
            'status' => $this->faker->randomElement(['completed', 'pending', 'cancelled']),
        ];
    }
}