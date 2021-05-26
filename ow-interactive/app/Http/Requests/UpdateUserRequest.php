<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Update User Request",
 *      description="Update User Request body data",
 *      type="object",
 *      required={"value_initial"}
 * )
 */
class UpdateUserRequest extends FormRequest
{

    /**
     * @OA\Property(
     *      title="Value Initial",
     *      description="Value Initial of the new user",
     *      format="decimal",
     *      example="100.00"
     * )
     *
     * @var number
     */
    public $value_initial;

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
            'value_initial' => 'required|numeric',
        ];
    }
}
