<?php

declare(strict_types=1);

namespace Domain\Auth\Data;

class UserData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {
    }
}
