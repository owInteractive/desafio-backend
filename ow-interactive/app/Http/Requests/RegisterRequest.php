<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "birthday" => "required|date",
            "email" => "required|email|unique:users,email",
            "name" => "required|min:2|max:255",
            "password" => "required|min:8|max:64",
        ];
    }

    public function messages()
    {
        return [
            "birthday.required" => "data de nascimento é obrigatória",
            "birthday.date" => "data de nascimento informada não é válida",
            "email.required" => "e-mail é obrigatório",
            "email.email" => "e-mail informado não é válido",
            "email.unique" => "e-mail informado já está em uso",
            "name.required" => "nome é obrigatório",
            "name.min" => "o nome deve conter no mínimo 2 caracteres",
            "name.max" => "o nome deve conter no máximo 255 caracteres",
            "password.required" => "senha é obrigatória",
            "password.min" => "a senha deve conter no mínimo 8 caracteres",
            "password.max" => "a senha deve conter no máximo 64 caracteres",
        ];
    }
}
