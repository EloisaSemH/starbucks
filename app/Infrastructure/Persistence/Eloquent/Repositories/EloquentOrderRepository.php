<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Infrastructure\Persistence\Contracts\OrderRepository;
use App\Infrastructure\Persistence\Eloquent\Models\Order;

class EloquentOrderRepository implements OrderRepository
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }
}
