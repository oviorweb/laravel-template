<?php

declare(strict_types=1);

use Domain\Auth\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use function Pest\Laravel\postJson;

it('should send a request password link', function () {
    Notification::fake();

    $user = User::factory()->create();

    postJson(route('password.email'), [
        'email' => $user->email,
    ]);

    Notification::assertSentTo($user, ResetPassword::class);
});

it('should reset password with a valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    postJson(route('password.email'), [
        'email' => $user->email,
    ]);

    Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use ($user) {
        postJson(route('password.update'), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'password',
        ])
            ->assertSessionHasNoErrors();

        return true;
    });
});
