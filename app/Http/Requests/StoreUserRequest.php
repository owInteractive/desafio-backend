<?php

namespace App\Http\Requests;

use App\Rules\maiorIdade;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'=>'required|min:3|max:255',
            'email'=>[
                'required',
                'email',
                'max:255',
                'unique:users'
            ],
            'saldo_inicial'=>'nullable',
            'birthday'=>[
                'required',
                'date',
                new maiorIdade
            ],
        ];
    }
}
