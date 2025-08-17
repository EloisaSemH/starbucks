<?php

namespace App\Infrastructure\Persistence\Contracts;

use App\Domain\Entities\ProductEntity;

interface ProductRepository
{
    public function findOrFail(int $id): ProductEntity;

    public function save(ProductEntity $product): void;

    public function decrementStock(int $id, int $quantity): void;
}