<?php

namespace Tests\Support\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use function Pest\Laravel\postJson;

class LockoutTestHelper
{
    protected const MAX_ATTEMPT = 5;

    public function hitUntilAlmostLocked(User $user): void
    {
        for ($i = 0; $i < self::MAX_ATTEMPT; $i++) {
            postJson(route('login'), [
                'email' => $user->email,
                'password' => Str::random(9),
            ])->assertStatus(422);
        }
    }
}
