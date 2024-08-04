<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'user_id' => User::factory()->createOne()->id,
        ];
    }
}
