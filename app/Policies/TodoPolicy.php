<?php

namespace App\Policies;

use App\Enums\Todo\Permission\TodoAbilityEnum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoPolicy
{
    use HandlesAuthorization;

    public function __construct(protected readonly UserPolicy $userPolicy) {}

    public function before(User $user): ?bool
    {
        if ($this->userPolicy->isAdmin($user)) {
            return true;
        }

        return null;
    }

    public function create(User $user): bool
    {
        return $user->role->abilities->contains('slug', TodoAbilityEnum::CREATE_TODOS);
    }

    public function list(User $user): bool
    {
        return $user->role->abilities->contains('slug', TodoAbilityEnum::LIST_TODOS);
    }
}
