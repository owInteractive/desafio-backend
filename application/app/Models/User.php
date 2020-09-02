<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User Model",
 * )
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private int $id;

    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of the user",
     *      example="Yves Clêuder"
     * )
     *
     * @var string
     */
    private string $name;

    /**
     * @OA\Property(
     *      title="E-mail",
     *      description="E-mail of the user",
     *      example="yves.cl@live.com"
     * )
     *
     * @var string
     */
    private string $email;

    /**
     * @OA\Property(
     *      title="Password",
     *      description="Password of the user",
     *      example="123456"
     * )
     *
     * @var string
     */
    private string $password;

    /**
     * @OA\Property(
     *      title="Birthday",
     *      description="Birthday of the user",
     *     format="date",
     *     type="string"
     * )
     *
     * @var string
     */
    private string $birthday;

    /**
     * @OA\Property(
     *      title="Amount Initial",
     *      description="Amount Initial of the user",
     *      format="double",
     *      example="1000.00"
     * )
     *
     * @var number
     */
    private $amount_initial;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-09-01 14:00:00",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var string
     */
    private string $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-09-01 14:00:00",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var string
     */
    private string $updated_at;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthday',
        'amount_initial',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Ordena de forma descendente pelo ID.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeIdDescending(Builder $query): Builder
    {
        return $query->orderBy('id','DESC');
    }

    /**
     * Usuário tem várias transações
     *
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
