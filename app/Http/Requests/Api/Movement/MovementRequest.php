<?php

namespace App\Http\Requests\Api\Movement;

use App\Repositories\Movement\Enums\MovementType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'type' => ['required', Rule::in(values: MovementType::all()),],
            'value' => ['required', 'numeric'],
        ];
    }
}
