<?php

namespace Database\Factories;

use App\Infrastructure\Persistence\Eloquent\Models\Extra;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Persistence\Eloquent\Models\Extra>
 */
class ExtraFactory extends Factory
{
    protected $model = Extra::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'price_cents' => $this->faker->numberBetween(50, 200),
            'is_active' => true,
        ];
    }
}
