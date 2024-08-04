<?php

namespace App\Http\Requests\Todo;

use App\Models\Todo;
use App\Permissions\AbilityEnum;
use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('list', Todo::class);
    }

    public function rules(): array
    {
        return [];
    }
}
