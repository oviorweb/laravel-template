<?php

namespace Domain\App\Concerns;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

trait HasDomainFactory
{
    use HasFactory;

    protected static function newFactory()
    {
        $parts = Str::of(get_called_class())->explode('\\');
        $domain = $parts->get(1);
        $model = $parts->last();

        return app("Database\\Factories\\$domain\\{$model}Factory");
    }
}
