<?php

use App\Models\Ability;
use App\Models\Role;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('User is Admin', function () {
    $ability = Ability::factory()->createOne();
    $role = Role::factory()->createOne(['name' => 'Admin']);
    $role->abilities()->attach($ability);
    $user = User::factory()->createOne(['role_id' => $role->id]);
    $policy = new UserPolicy;
    expect($policy->isAdmin($user))->toBeTrue();
});

test('Failed User is not Admin', function () {
    $ability = Ability::factory()->createOne();
    $role = Role::factory()->createOne();
    $role->abilities()->attach($ability);
    $user = User::factory()->createOne(['role_id' => $role->id]);
    $policy = new UserPolicy;
    expect($policy->isAdmin($user))->toBeFalse();
});
