<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Domain\Auth\Data\PasswordResetData;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordAction
{
    public static function execute(PasswordResetData $data)
    {
        return Password::reset($data->all(), function (User $user) use ($data) {
            $user->forceFill([
                'password' => Hash::make($data->password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        });
    }
}
