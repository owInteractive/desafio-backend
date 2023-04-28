<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransacionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'value' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
            'transaction_type_id' => 'required|exists:transaction_types,id',
        ];
    }
}
