<?php

namespace Domain\Auth\Data;

class PasswordResetData
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $token,
    ) {
    }
}
