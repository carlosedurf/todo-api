<?php

use App\Models\Ability;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('Failed create todo send without auth', function () {
    $payload = ['title' => fake()->title];
    $response = $this->postJson('/api/todo', $payload);
    $response->assertUnauthorized();
});

it('Can create todo send with auth', function () {
    $payload = ['title' => fake()->title];
    $user = User::factory()->createOne();
    $ability = Ability::factory()->createOne(['slug' => 'create-todo']);
    $user->role->abilities()->attach($ability);
    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$user->createToken('Token')->plainTextToken,
    ])
        ->postJson('/api/todo', $payload);
    $response->assertCreated();
    expect(Todo::where('title', $payload['title'])->exists())->toBeTrue();
});

it('Cannot permission create todo send with auth', function () {
    $payload = ['title' => fake()->title];
    $user = User::factory()->createOne();
    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$user->createToken('Token')->plainTextToken,
    ])
        ->postJson('/api/todo', $payload);
    $response->assertForbidden();
});
