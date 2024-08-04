<?php

namespace App\Observers\Todo;

use App\Models\Todo;
use Illuminate\Support\Str;

class TodoObserver
{
    public function creating(Todo $todo): void
    {
        if (empty($todo->uuid)) {
            $todo->uuid = Str::uuid();
        }
    }
}
