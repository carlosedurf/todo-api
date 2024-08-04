<?php

use App\Enums\Todo\Permission\TodoAbilityEnum;
use App\Models\Ability;
use App\Models\Role;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('Can list todos by user', function () {
    $user = User::factory()->createOne();
    $ability = Ability::factory()->createOne(['slug' => TodoAbilityEnum::LIST_TODOS]);
    $user->role->abilities()->attach($ability);
    Todo::factory()->count(10)->create();
    Todo::factory()->count(10)->create(['user_id' => $user->id]);

    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$user->createToken('Token Test')->plainTextToken,
    ])->getJson('/api/todos');
    $response->assertOk();
    $response->assertJsonCount(10, 'data');
    expect(Todo::where('user_id', $user->id)->count())->toBe(10);
});

it('Admin Can list all todos', function () {
    $role = Role::factory()->createOne(['name' => 'Admin']);
    $user = User::factory()->createOne(['role_id' => $role->id]);
    $ability = Ability::factory()->createOne(['slug' => TodoAbilityEnum::LIST_TODOS]);
    $user->role->abilities()->attach($ability);
    Todo::factory()->count(10)->create();
    Todo::factory()->count(10)->create(['user_id' => $user->id]);

    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$user->createToken('Token Test')->plainTextToken,
    ])->getJson('/api/todos');
    $response->assertOk();
    $response->assertJsonCount(20, 'data');
});

it('Owner Can list all todos your company', function () {
    $role = Role::factory()->createOne(['name' => 'Owner']);
    $user = User::factory()->createOne(['role_id' => $role->id]);
    $ability = Ability::factory()->createOne(['slug' => TodoAbilityEnum::LIST_TODOS]);
    $user->role->abilities()->attach($ability);
    Todo::factory()->count(10)->create();
    Todo::factory()->count(10)->create(['user_id' => $user->id]);
    User::factory()
        ->count(5)
        ->create(['company_id' => $user->company_id])
        ->each(fn (User $u) => Todo::factory()->count(10)->create(['user_id' => $u->id]));

    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$user->createToken('Token Test')->plainTextToken,
    ])->getJson('/api/todos');
    $response->assertOk();
    $response->assertJsonCount(60, 'data');
});
