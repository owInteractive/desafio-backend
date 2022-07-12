<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Create Transaction Request",
 *      description="Create Transaction Request body data",
 *      type="object",
 *      required={"user_id", "transaction_type_id", "value"}
 * )
 */
class CreateTransactionRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Value",
     *      description="Value of the new transaction",
     *      format="decimal",
     *      example="1000.00"
     * )
     *
     * @var number
     */
    public $value;

    /**
     * @OA\Property(
     *      title="User ID",
     *      description="User of the new transaction",
     *      format="integer",
     *      example="1"
     * )
     *
     * @var integer
     */
    private $user_id;

    /**
     * @OA\Property(
     *      title="Type Transaction",
     *      description="Type of the new transaction",
     *      format="integer",
     *      example="1"
     * )
     *
     * @var integer
     */
    private $transaction_type_id;

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
            'value' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
            'transaction_type_id' => 'required|exists:transaction_types,id',
        ];
    }
}
