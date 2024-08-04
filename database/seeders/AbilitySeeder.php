<?php

namespace Database\Seeders;

use App\Models\Ability;
use Illuminate\Database\Seeder;

class AbilitySeeder extends Seeder
{
    public function run(): void
    {
        Ability::factory()->count(100)->create();
    }
}
