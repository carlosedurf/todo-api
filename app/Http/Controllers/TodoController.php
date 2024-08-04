<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\StoreTodoRequest;
use App\Models\Todo;

class TodoController extends Controller
{
    public function store(StoreTodoRequest $request)
    {
        Todo::create($request->all());

        return response()->noContent(201);
    }
}
