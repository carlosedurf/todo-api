<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Str;

class UserPolicy
{
    public function isAdmin(User $user): bool
    {
        return Str::lower($user->role->name) === 'admin';
    }
}
