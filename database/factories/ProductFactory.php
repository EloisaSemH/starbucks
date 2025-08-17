<?php

namespace Database\Factories;

use App\Infrastructure\Persistence\Eloquent\Models\Category;
use App\Infrastructure\Persistence\Eloquent\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Persistence\Eloquent\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->unique()->word(),
            'price_cents' => $this->faker->numberBetween(100, 1000),
            'stock' => $this->faker->numberBetween(100, 1000),
        ];
    }

    /**
     * Create a product with extras attached.
     */
    public function withExtras(array $extraIds = []): static
    {
        return $this->afterCreating(function (Product $product) use ($extraIds) {
            if (!empty($extraIds)) {
                $product->extras()->attach($extraIds);
            }
        });
    }
}