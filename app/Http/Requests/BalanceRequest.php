<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BalanceRequest extends FormRequest
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
            'value'=>"required|regex:/^\d*(\.\d{2})?$/", 
            'user_id'=>"required|exists:users,id",
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
            'value.required'=>'O campo <value> do saldo é obrigatório', 
            'value.regex'=>'O campo <value> é inválido. Precisa ser um <value> decimal, separado por ponto', 
            'user_id.required'=>'O campo <user_id> do saldo é obrigatório', 
            'user_id.exists'=>'O campo <user_id> não existe na base de dados',  
        ];
    }
}
