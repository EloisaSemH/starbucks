<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Entities\ProductEntity;
use App\Domain\ValueObjects\Money;
use App\Infrastructure\Persistence\Contracts\ProductRepository;
use App\Infrastructure\Persistence\Eloquent\Models\Product;

class EloquentProductRepository implements ProductRepository
{
    public function findOrFail(int $id): ProductEntity
    {
        $model = Product::findOrFail($id);
        return new ProductEntity(
            id: $model->id,
            name: $model->name,
            price: Money::fromInt($model->price_cents),
            stock: $model->stock,
        );
    }

    public function save(ProductEntity $product): void
    {
        Product::updateOrCreate(
            ['id' => $product->id],
            ['name' => $product->name, 'price_cents' => $product->price->cents(), 'stock' => $product->stock],
        );
    }

    public function decrementStock(int $id, int $quantity): void
    {
        Product::whereKey($id)->decrement('stock', $quantity);
    }
}
