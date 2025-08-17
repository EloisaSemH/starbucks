<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Infrastructure\Persistence\Contracts\ExtraRepository;
use App\Infrastructure\Persistence\Eloquent\Models\Extra;

class EloquentExtraRepository implements ExtraRepository
{
    public function findByIds(array $ids): array
    {
        return Extra::whereIn('id', $ids)->where('is_active', true)->get()->all();
    }
}
