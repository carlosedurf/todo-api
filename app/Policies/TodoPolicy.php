<?php

namespace App\Policies;

use App\Models\User;

class TodoPolicy
{
    public function create(User $user): bool
    {
        return $user->role->abilities->contains('slug', 'create-todo');
    }
}
