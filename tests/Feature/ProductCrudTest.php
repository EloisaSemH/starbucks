<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Infrastructure\Persistence\Eloquent\Models\{Product, Category, Extra, OrderItem};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testCrudFlow(): void
    {
        $category = Category::factory()->create();
        $extraA = Extra::factory()->create();
        $extraB = Extra::factory()->create();

        // CREATE
        $create = $this->postJson('/api/products', [
            'category_id' => $category->id,
            'name' => 'Latte',
            'price_cents' => 350,
            'stock' => 50,
            'extras' => [$extraA->id, $extraB->id],
        ]);

        $create->assertCreated();
        $productId = $create->json('data.id');

        // INDEX
        $this->getJson('/api/products?per_page=10')->assertOk()->assertJsonPath('data.0.id', $productId);

        // SHOW
        $this->getJson("/api/products/{$productId}")
            ->assertOk()
            ->assertJsonPath('data.name', 'Latte');

        // UPDATE
        $this->putJson("/api/products/{$productId}", [
            'name' => 'Latte Forte',
            'stock' => 40,
            'extras' => [$extraA->id],
        ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Latte Forte');

        // DELETE
        $this->deleteJson("/api/products/{$productId}")->assertNoContent();
        $this->getJson("/api/products/{$productId}")->assertNotFound();
    }

    public function testCannotDeleteProductWithOrders(): void
    {
        $product = Product::factory()->create();

        OrderItem::factory()->create(['product_id' => $product->id]);

        $this->deleteJson("/api/products/{$product->id}")->assertBadRequest();
    }
}
