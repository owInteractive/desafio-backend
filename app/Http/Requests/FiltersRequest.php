<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class FiltersRequest extends FormRequest
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
                'type'=>"required|in:last_30_days,by_date,all",
                'date'=>'required_if:type,by_date|date_format:m/Y|after:12/1899'
            ];
        }else{
            return [
                'type'=>"required|in:last_30_days,by_date,all",
                'date'=>'required_if:type,by_date|date_format:m/Y|after:12/1899',
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
            'type.required'=>"Defina o tipo do filtro pela propriedade <type>",
            'type.in'=>"O campo <type> é inválido, formatos aceitos <last_30_days> (Últimos 30 dias), <by_date> (por mês e ano) , <all> todas movimentações",
            'date.required_if'=>'Para o filtro <by_date> o campo <date> é obrigatório',
            'date.date_format'=>'O campo <date> está em formato inválido, formato aceito m / Y',
            'date.after'=>'O campo <date> precisa ser superior ao ano 1900',
            'user_id.required'=>'O campo <user_id> da movimentação é obrigatório', 
            'user_id.exists'=>'O campo <user_id> não existe na base de dados', 
        ];
    }
}
