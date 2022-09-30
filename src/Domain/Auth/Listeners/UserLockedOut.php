<?php

declare(strict_types=1);

namespace Domain\Auth\Listeners;

use Domain\Auth\Models\User;
use Domain\Auth\Notifications\LockedOut;
use Illuminate\Auth\Events\Lockout;

class UserLockedOut
{
    public function handle(Lockout $event): void
    {
        if ($user = User::firstWhere('email', $event->request->email)) {
            $user->notify(new LockedOut);
        }
    }
}
