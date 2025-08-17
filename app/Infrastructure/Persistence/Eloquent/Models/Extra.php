<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Extra extends BaseModel
{
    protected $fillable = ['name', 'price_cents', 'is_active'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_extra');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItemExtra::class);
    }
}
