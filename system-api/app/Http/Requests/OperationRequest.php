<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OperationRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'operation_type_id' => 'required|exists:operation_types,id',
            'amount' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo é obrigátorio',
            'user_id.exists' => 'O id deve existir na tabela de Usuários.',
            'operation_type_id.exists' => 'O id deve existir na tabela de Tipos de Operação',
            'numeric' => 'O campo deve ser numerico'
        ];
    }
}
