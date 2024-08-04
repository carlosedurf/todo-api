<?php

use App\Models\Ability;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

dataset('role', [
    fn () => Role::factory()->createOne(),
]);

dataset('ability', [
    fn () => Ability::factory()->createOne(),
]);

it('can create a role', function (Role $role) {
    expect(Role::find($role->id)->exists())->toBeTrue();
})
    ->with([
        fn () => Role::factory()->createOne(),
    ]);

it('Can linked ability with a role', function (Role $role, Ability $ability) {
    $role->abilities()->attach($ability);
    $exists = DB::table('ability_role')
        ->where('role_id', $role->id)
        ->where('ability_id', $ability->id)
        ->exists();
    expect($exists)->toBe(true);
})
    ->with('role')
    ->with('ability');

it('Can listing abilities by role', function (Role $role) {
    Ability::factory()->count(10)->create()->each(fn ($ability) => $role->abilities()->attach($ability));
    $role->refresh();
    expect($role->abilities)->toHaveCount(10);
})->with('role');
