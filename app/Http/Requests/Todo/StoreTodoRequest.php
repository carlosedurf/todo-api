<?php

namespace App\Http\Requests\Todo;

use App\Models\Todo;
use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Todo::class);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
        ];
    }
}
