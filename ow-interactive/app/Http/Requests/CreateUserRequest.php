<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Create User Request",
 *      description="Create User Request body data",
 *      type="object",
 *      required={"name", "email", "password", "birthday"}
 * )
 */
class CreateUserRequest extends FormRequest
{

    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of the new user",
     *      example="Example"
     * )
     */
    public $name;

    /**
     * @OA\Property(
     *      title="E-mail",
     *      description="E-mail of the new user",
     *      example="example@example.com"
     * )
     */
    public $email;

    /**
     * @OA\Property(
     *      title="Password",
     *      description="Password of the new user",
     *      example="example"
     * )
     */
    public $password;

    /**
     * @OA\Property(
     *      title="Birthday",
     *      description="Birthday of the new user",
     *     format="date",
     *     type="string"
     * )
     */
    public $birthday;

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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|max:255',
            'birthday' => 'required|date|before:'.Carbon::now()->subYears(18)->format('Y-m-d')
        ];
    }

    public function messages()
    {
        return [
            'birthday.before' => 'You must be over 18 years old.',
        ];
    }
}
