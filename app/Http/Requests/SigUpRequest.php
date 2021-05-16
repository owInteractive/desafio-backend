<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SigUpRequest extends FormRequest
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
            'name'=>'required',
            'password'=>'required',
            'email'=>'required|email|unique:users',
            'birthday'=>'required|date_format:Y-m-d|after:1899-12-31|before:-18 years'
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
            'name.required'=>'O campo <name> do usuário é obrigatório',
            'password.required'=>'O campo <password> do usuário é obrigatório',
            'email.required'=>'O campo <email> do usuário é obrigatório',
            'email.email'=>'O campo <email> do usuário está em formato inválido',
            'email.unique'=>'O campo <email> está em uso por outro usuário cadastrado',
            'birthday.required'=>'O campo <birthday> do usuário é obrigatório',
            'birthday.date_format'=>'O campo <birthday> está em formato inválido, formato aceito Y-m-d',
            'birthday.after'=>'O campo <birthday> precisa ser superior ao ano 1900',
            'birthday.before'=>'Somente é possivel cadastrar usuários maiores de 18 anos',
        ];
    }
}
