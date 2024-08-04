<?php

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a role', function (Role $role) {
    expect(Role::find($role->id)->exists())->toBeTrue();
})
    ->with([
        fn () => Role::factory()->createOne(),
    ]);
