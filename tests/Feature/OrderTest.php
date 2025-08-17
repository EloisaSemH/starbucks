<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Infrastructure\Persistence\Eloquent\Models\{Product, Extra};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function testPlacesOrderAndReturnsChange(): void
    {
        $product = Product::factory()->create([
            'price_cents' => 350,
            'stock' => 10,
        ]);

        $extra1 = Extra::factory()->create(['price_cents' => 50]);
        $extra2 = Extra::factory()->create(['price_cents' => 70]);
        $product->extras()->attach([$extra1->id, $extra2->id]);

        $payload = [
            'products' => [
                [
                    'id' => $product->id,
                    'quantity' => 2,
                    'extras' => [$extra1->id, $extra2->id],
                ],
            ],
            'paid_cents' => 1200,
        ];

        $response = $this->postJson('/api/orders', $payload);
        $response->assertCreated();

        $response->assertJsonPath('data.total_cents', 940);
        $response->assertJsonPath('data.paid_cents', 1200);
        $response->assertJsonPath('data.change_cents', 260);

        $product->refresh();
        $this->assertSame(8, $product->stock);
    }

    public function testFailsOnInsufficientStock(): void
    {
        $product = Product::factory()->create(['price_cents' => 300, 'stock' => 1]);

        $response = $this->postJson('/api/orders', [
            'products' => [
                [
                    'id' => $product->id,
                    'quantity' => 2,
                    'extras' => [],
                ],
            ],
            'paid_cents' => 1000,
        ]);

        $response->assertStatus(422)->assertJson(['message' => 'Insufficient stock']);
    }

    public function testFailsOnInsufficientFunds(): void
    {
        $product = Product::factory()->create(['price_cents' => 400, 'stock' => 5]);

        $response = $this->postJson('/api/orders', [
            'products' => [
                [
                    'id' => $product->id,
                    'quantity' => 2,
                    'extras' => [],
                ],
            ],
            'paid_cents' => 700,
        ]);

        $response->assertStatus(422)->assertJson(['message' => 'Insufficient funds']);
    }
}