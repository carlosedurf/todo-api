<?php

use App\Models\Ability;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create ability', function (Ability $ability) {
    expect(Ability::find($ability->id)->exists())->toBeTrue();
})
    ->with([
        fn () => Ability::factory()->createOne(),
    ]);
