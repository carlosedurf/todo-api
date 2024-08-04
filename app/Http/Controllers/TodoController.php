<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\StoreTodoRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
    public function store(StoreTodoRequest $request)
    {
        $user = Auth::user();
        $user->todos()->create($request->all());

        return response()->noContent(Response::HTTP_CREATED);
    }
}
