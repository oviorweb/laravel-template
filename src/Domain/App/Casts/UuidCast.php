<?php

declare(strict_types=1);

namespace Domain\App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UuidCast implements CastsAttributes
{
    public function get($model, $key, $value, $attributes): UuidInterface
    {
        return Uuid::fromString($value);
    }

    public function set($model, $key, $value, $attributes): string
    {
        return (string) $value;
    }
}
