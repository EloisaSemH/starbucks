<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Infrastructure\Persistence\Eloquent\Models\{Product, Category, Extra, OrderItemExtra};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ExtraCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testCrudFlow(): void
    {
        // CREATE
        $create = $this->postJson('/api/extras', [
            'name' => 'Cinnamon',
            'price_cents' => 50,
        ]);

        $create->assertCreated();
        $extraId = $create->json('data.id');

        // INDEX
        $this->getJson('/api/extras?per_page=10')->assertOk()->assertJsonPath('data.0.id', $extraId);

        // SHOW
        $this->getJson("/api/extras/{$extraId}")
            ->assertOk()
            ->assertJsonPath('data.name', 'Cinnamon');

        // UPDATE
        $this->putJson("/api/extras/{$extraId}", [
            'name' => 'Cinnamon Extra',
        ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Cinnamon Extra');

        // DELETE
        $this->deleteJson("/api/extras/{$extraId}")->assertNoContent();
        $this->getJson("/api/extras/{$extraId}")->assertNotFound();
    }

    public function testCannotDeleteExtraWithProducts(): void
    {
        $extra = Extra::factory()->create();

        OrderItemExtra::factory()->create(['extra_id' => $extra->id]);

        $this->deleteJson("/api/extras/{$extra->id}")->assertBadRequest();
    }
}