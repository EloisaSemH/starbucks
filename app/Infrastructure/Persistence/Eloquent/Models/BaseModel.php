<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        $basename = class_basename(static::class);
        $factory = "\\Database\\Factories\\{$basename}Factory";

        if (class_exists($factory) && method_exists($factory, 'new')) {
            return $factory::new();
        }

        throw new \RuntimeException('Factory not found for model ' . static::class . " at {$factory}");
    }
}