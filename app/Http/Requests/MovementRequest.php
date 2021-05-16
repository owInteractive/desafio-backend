<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class MovementRequest extends FormRequest
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
        if(!empty($request->user())){
            return [ 
                'operation'=>"required|in:credit,debit,reversal",
                'value'=>"required|regex:/^\d*(\.\d{2})?$/"
            ];
        }else{
            return [ 
                'operation'=>"required|in:credit,debit,reversal",
                'value'=>"required|regex:/^\d*(\.\d{2})?$/",
                'user_id'=>"required|exists:users,id",
            ];
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
            'operation.required'=>'O campo <operation> da movimentação é obrigatório',
            'operation.in'=>'O campo <operation> é inválido. Formatos aceitos: credit,debit,reversal',
            'value.required'=>'O campo <value> da movimentação é obrigatório', 
            'value.regex'=>'O campo <value> é inválido. Precisa ser um <value> decimal, separado por ponto', 
            'user_id.required'=>'O campo <user_id> da movimentação é obrigatório', 
            'user_id.exists'=>'O campo <user_id> não existe na base de dados', 
        ];
    }
}
