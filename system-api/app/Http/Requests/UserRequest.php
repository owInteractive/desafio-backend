<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'birthday' => 'required|date|before:'.Carbon::now()->subYears(18)->format('Y-m-d'),
            'opening_balance' => 'numeric'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O Campo é obrigatório.',
            'max:255' => 'O tamanho maximo do campo é de 255 caracteres.',
            'email.unique' => 'O email deve ser unico.',
            'birthday.date' => 'O campo deve ser do tipo data.',
            'birthday.before' => 'Cadastro permitido somente para maiores de 18 anos.',
            'numeric' => 'O campo deve ser numerico.'
        ];
    }
}
