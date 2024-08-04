<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\ListRequest;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Resources\Todo\ListResource;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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

    public function list(ListRequest $request): AnonymousResourceCollection
    {
        $user = Auth::user();
        if ($user->can('isAdmin', User::class)) {
            $todos = Todo::orderBy('created_at', 'desc')->get();
        } elseif ($user->can('isOwner', User::class)) {
            $todos = Todo::whereHas('user', fn (Builder $query) => $query->where('company_id', $user->company_id))
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $todos = $user->todos()->orderBy('created_at', 'desc')->get();
        }

        return ListResource::collection($todos);
    }
}
