<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends BaseModel
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'unit_price_cents', 'line_total_cents'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function extras(): HasMany
    {
        return $this->hasMany(OrderItemExtra::class);
    }
}
