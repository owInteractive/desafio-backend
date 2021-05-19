<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Excel;


class TransactionStoreRequest extends FormRequest
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
            'amount' => ["required",  'regex:/^[0-9]+(?:\.[0-9]+)?$/'],
            'transaction_type' => ['required',
                Rule::in(['credit', 'debit','reversal']),
            ],
            'user_email' => Rule::requiredIf(!$this->request->has('user_id')),
            'user_id' => Rule::requiredIf(!$this->request->has('user_email'))
        ];
    }
}
