<?php

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('Can create a company', function () {
    $data = [
        'name' => fake()->company,
    ];
    Company::create($data);
    expect(Company::where('name', $data['name'])->exists())->toBeTrue();
});
