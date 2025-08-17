<?php

namespace App\Infrastructure\Persistence\Contracts;

use App\Infrastructure\Persistence\Eloquent\Models\Extra;

interface ExtraRepository
{
    /** @return Extra[] */
    public function findByIds(array $ids): array;
}
