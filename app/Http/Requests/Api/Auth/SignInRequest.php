<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email','unique:users,email'],
            'password' => ['required', 'string'],
            'password_confirmation' => ['required', 'string', 'same:password'],
            'birthday' => ['required', 'date', 'date_format:Y-m-d'],
            'opening_balance' => ['sometimes'],
        ];
    }
}
