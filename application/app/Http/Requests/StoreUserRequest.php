<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store User Request",
 *      description="Store User Request body data",
 *      type="object",
 *      required={"name", "email", "password", "birthday", "amount_initial"}
 * )
 */
class StoreUserRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of the new user",
     *      example="Yves Clêuder"
     * )
     *
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *      title="E-mail",
     *      description="E-mail of the new user",
     *      example="yves.cl@live.com"
     * )
     *
     * @var string
     */
    public string $email;

    /**
     * @OA\Property(
     *      title="Password",
     *      description="Password of the new user",
     *      example="123456"
     * )
     *
     * @var string
     */
    public string $password;

    /**
     * @OA\Property(
     *      title="Birthday",
     *      description="Birthday of the new user",
     *     format="date",
     *     type="string"
     * )
     *
     * @var string
     */
    public string $birthday;

    /**
     * @OA\Property(
     *      title="Amount Initial",
     *      description="Amount Initial of the new user",
     *      format="double",
     *      example="1000.00"
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
            'name'           => 'required|min:4|max:255',
            'email'          => 'required|email|max:255|unique:users,email',
            'password'       => 'required|min:5|max:255',
            'birthday'       => 'required|date|before:'.\Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
            'amount_initial' => 'required|regex:/^\d{1,15}(\.\d{1,2})?$/',
        ];
    }

    public function messages()
    {
        return [
            'birthday.before' => 'Você precisa ser maior de 18 anos.',
        ];
    }
}
