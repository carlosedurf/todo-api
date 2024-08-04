<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('Can create a user by instance object', function () {
    $data = [
        'name' => fake()->name,
        'email' => fake()->email,
        'password' => bcrypt(fake()->password),
    ];
    $user = new User;
    $user->fill($data);
    $user->save();
    expect(User::where('email', $data['email'])->exists())->toBeTrue();
});

it('Can create a user by massive', function () {
    $data = [
        'name' => fake()->name,
        'email' => fake()->email,
        'password' => bcrypt(fake()->password),
    ];
    User::create($data);
    expect(User::where('email', $data['email'])->exists())->toBeTrue();
});
