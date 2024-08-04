<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

dataset('users', [
    fn () => [
        'role_id' => Role::factory()->createOne()->id,
        'name' => fake()->name,
        'email' => fake()->email,
        'password' => fake()->password,
    ],
]);

dataset('user', [
    fn () => User::factory()->createOne(),
]);

it('Can create a user by instance object', function (array $data) {
    $user = new User;
    $user->fill($data);
    $user->save();
    expect(User::where('email', $data['email'])->exists())->toBeTrue();
})->with('users');

it('Can create a user by massive', function (array $data) {
    User::create($data);
    expect(User::where('email', $data['email'])->exists())->toBeTrue();
})->with('users');

it('Can update a role user', function (User $user) {
    $role = Role::factory()->createOne();
    $user->role_id = $role->id;
    $user->save();
    $user->refresh();
    expect($user->role_id)->toBe($role->id);
})->with('user');

it('Can get name role by user', function (User $user) {
    expect($user->role->name)->not()->toBeEmpty();
})->with('user');
