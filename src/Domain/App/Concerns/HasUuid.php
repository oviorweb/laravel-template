<?php

declare(strict_types=1);

namespace Domain\App\Concerns;

use Illuminate\Database\Eloquent\Model;
use Str;

trait HasUuid
{
    public static function bootHasUuid(): void
    {
        static::creating(function (Model $model) {
            $model->uuid = Str::uuid();
        });
    }
}
