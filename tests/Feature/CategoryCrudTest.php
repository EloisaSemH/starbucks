<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Infrastructure\Persistence\Eloquent\Models\{Product, Category, Extra};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testCrudFlow(): void
    {
        // CREATE
        $create = $this->postJson('/api/categories', [
            'name' => 'Coffee Drinks',
        ]);

        $create->assertCreated();
        $categoryId = $create->json('data.id');

        // INDEX
        $this->getJson('/api/categories?per_page=10')->assertOk()->assertJsonPath('data.0.id', $categoryId);

        // SHOW
        $this->getJson("/api/categories/{$categoryId}")
            ->assertOk()
            ->assertJsonPath('data.name', 'Coffee Drinks');

        // UPDATE
        $this->putJson("/api/categories/{$categoryId}", [
            'name' => 'Espresso Drinks',
        ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Espresso Drinks');

        // DELETE
        $this->deleteJson("/api/categories/{$categoryId}")->assertNoContent();
        $this->getJson("/api/categories/{$categoryId}")->assertNotFound();
    }

    public function testCannotDeleteCategoryWithProducts(): void
    {
        $category = Category::factory()->create();

        Product::factory()->create(['category_id' => $category->id]);
        $this->getJson('/api/products?category_id=' . $category->id)
            ->assertOk()
            ->assertJsonCount(1, 'data');

        $this->deleteJson("/api/categories/{$category->id}")->assertBadRequest();
    }
}