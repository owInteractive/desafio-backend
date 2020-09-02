<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Index Transaction Request",
 *      description="Index Transaction Request Query String",
 *      type="object"
 * )
 */
class IndexTransactionRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Page",
     *      description="Page this pagination",
     *      example="1"
     * )
     *
     * @var integer
     */
    public int $page;

    /**
     * @OA\Property(
     *      title="Per Page",
     *      description="Amount of data per page",
     *      example="15"
     * )
     *
     * @var integer
     */
    public int $per_page;

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
            'page'     => 'filled|integer',
            'per_page' => 'filled|integer'
        ];
    }
}
