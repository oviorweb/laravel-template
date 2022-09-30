<?php

declare(strict_types=1);

use Domain\Auth\Models\User;
use Domain\Auth\Notifications\LockedOut;
use Illuminate\Auth\Events\Lockout;
use function Pest\Laravel\postJson;
use Tests\Support\Auth\LockoutTestHelper;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->helper = new LockoutTestHelper();
    $this->helper->hitUntilAlmostLocked($this->user);
});

it('should lock the user when multiple requests is made', function () {
    Event::fake();
    postJson(route('login'), [
        'email' => $this->user->email,
        'password' => 'password123',
    ])
        ->assertStatus(422);
    Event::assertDispatched(Lockout::class);
});

it('should send a notification to the user when locked out', function () {
    Notification::fake();

    postJson(route('login'), [
        'email' => $this->user->email,
        'password' => 'password123',
    ])->assertStatus(422);

    Notification::assertSentTo($this->user, LockedOut::class);
});
