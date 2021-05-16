<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SigInRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ];
    }

    /**
     * Show custom messages to the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required'=>'O campo <email> do usuário é obrigatório',
            'email.email'=>'O campo <email> do usuário está em formato inválido',
            'email.exists'=>'O campo <email> não existe na base de dados',
            'password.required'=>'O campo <password> do usuário é obrigatório',
        ];
    }
}
