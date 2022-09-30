<?php

declare(strict_types=1);

use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\postJson;

it('should register new users', function () {
    postJson(route('register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertNoContent();

    assertDatabaseHas('users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    assertAuthenticated();
});

it('should make sure password are not stored in plain', function (string $password) {
    postJson(route('register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => $password,
        'password_confirmation' => $password,
    ]);
    assertDatabaseMissing('users', [
        'password' => $password,
    ]);
})->with([
    'password',
    't1t2t3t4',
    'yothisiscool',
]);

it('should return 422 if password is not valid', function (?string $password) {
    postJson(route('register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => $password,
        'password_confirmation' => $password,
    ])->assertInvalid('password');
})->with([
    '',
    'test',
    '2134',
    'yo',
    null,
]);
