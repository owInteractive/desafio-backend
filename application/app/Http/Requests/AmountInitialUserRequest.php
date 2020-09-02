<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Amount Inicial User Request",
 *      description="Amount Inicial User body data",
 *      type="object",
 *      required={"amount_initial"}
 * )
 */
class AmountInitialUserRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Amount Initial",
     *      description="Amount Initial of the user",
     *      format="double",
     *      example="500.00"
     * )
     *
     * @var number
     */
    public $amount_initial;

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
            'amount_initial' => 'required|regex:/^\d{1,15}(\.\d{1,2})?$/',
        ];
    }
}
