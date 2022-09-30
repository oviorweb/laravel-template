<?php

declare(strict_types=1);

use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Verified;
use function Pest\Laravel\actingAs;

it('should make sure email can be verified', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    actingAs($user)
        ->get($verificationUrl)
        ->assertRedirect(config('app.frontend_url').\Domain\App\Providers\RouteServiceProvider::HOME.'?verified=1');
    Event::assertDispatched(Verified::class);

    expect($user->fresh()->hasVerifiedEmail())
        ->toBeTrue();
});

it('should make sure email is not verified with invalid hash', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    actingAs($user)
        ->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())
        ->toBeFalse();
});
