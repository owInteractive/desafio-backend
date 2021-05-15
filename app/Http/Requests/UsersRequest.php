<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UsersRequest extends FormRequest
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
    public function rules(Request $request)
    {
        switch(true) {
            case $request->isMethod('post'):
                return [
                    'name'=>'required',
                    'email'=>'required|email|unique:users',
                    'birthday'=>'required|date_format:Y-m-d|after:1899-12-31|before:-18 years'
                ];
            break;
            case $request->isMethod('put'): 
                return [
                    'name'=>'required',
                    'email'=>"required|email|unique:users,email,$request->user,id",
                    'birthday'=>'required|date_format:Y-m-d|after:1899-12-31|before:-18 years'
                ];
            break;
        }
        
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
