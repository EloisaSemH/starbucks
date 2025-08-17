<?php

namespace App\Infrastructure\Persistence\Contracts;

use App\Infrastructure\Persistence\Eloquent\Models\Order;

interface OrderRepository
{
    public function create(array $data): Order;
}
