<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends BaseModel
{
    protected $fillable = ['total_cents', 'paid_cents', 'change_cents', 'status'];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}