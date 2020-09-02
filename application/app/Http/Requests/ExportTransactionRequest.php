<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Export Transaction Request",
 *      description="Export Transaction body data",
 *      type="object"
 * )
 */
class ExportTransactionRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Type Filter",
     *      description="Choose only type filter",
     *      format="integer",
     *      example="2"
     * )
     *
     * @var integer
     */
    private int $type;

    /**
     * @OA\Property(
     *      title="Period",
     *      description="Choose period for filter",
     *      format="date",
     *      example="08/2020"
     * )
     *
     * @var string
     */
    private string $period;

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
            'type' => 'required',
            'period' => 'required_if:type,2'
        ];
    }
}
