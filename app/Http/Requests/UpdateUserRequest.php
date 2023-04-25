<?php

namespace App\Http\Requests;

use App\Rules\maiorIdade;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name'=>'nullable|min:3|max:255',
            'email'=>[
                'nullable',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->id)
            ],
            'birthday'=>[
                'nullable',
                'date',
                new maiorIdade
            ],
            'saldo_inicial'=>'nullable',
        ];
    }
}
