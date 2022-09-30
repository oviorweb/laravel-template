<?php

namespace Domain\Auth\Data;

use Illuminate\Validation\Rules\Password;
use Spatie\LaravelData\Data;

class PasswordResetData extends Data
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $token,
    ) {
    }

    public static function rules(): array
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', Password::defaults()],
        ];
    }
}
