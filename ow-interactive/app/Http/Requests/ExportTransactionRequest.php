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
     *      title="Filter Type",
     *      description="
               Choose only the type of filter.
               (Filter type NULL = returns all transactions.)
               (Filter type 1 = returns the last 30 days)
               (Filter type 2 = returns the specific month and year)",
     *      format="integer",
     *      example="1"
     * )
     */
    private $filter_type;

    /**
     * @OA\Property(
     *      title="Date Filter",
     *      description="Choose period for filter",
     *      format="date",
     *      example="09/2020"
     * )
     */
    private $date_filter;

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
            'filter_type' => 'required',
            'date_filter' => 'required_if:filter_type,2'
        ];
    }
}
