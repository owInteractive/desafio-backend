<?php

namespace App\Http\Requests\Api\Movement;

use App\Repositories\Movement\Enums\MovementType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
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
            'last_thirty_days' => ['sometimes', 'bool'],
            'month' => ['sometimes', 'date', 'date_format:Y-m'],
            'all' => ['sometimes', 'bool'],
        ];
    }
}
