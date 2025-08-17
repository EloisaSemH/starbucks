<?php

namespace Database\Factories;

use App\Infrastructure\Persistence\Eloquent\Models\Extra;
use App\Infrastructure\Persistence\Eloquent\Models\OrderItem;
use App\Infrastructure\Persistence\Eloquent\Models\OrderItemExtra;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Persistence\Eloquent\Models\OrderItemExtra>
 */
class OrderItemExtraFactory extends Factory
{
    protected $model = OrderItemExtra::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_item_id' => OrderItem::factory(),
            'extra_id' => Extra::factory(),
            'price_cents' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
