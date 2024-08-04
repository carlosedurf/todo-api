<?php

namespace App\Models;

use App\Observers\Todo\TodoObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    protected static function boot()
    {
        parent::boot();
        static::observe(TodoObserver::class);
    }
}
