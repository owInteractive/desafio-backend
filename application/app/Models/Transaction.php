<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     title="Transaction",
 *     description="Transaction Model",
 * )
 */
class Transaction extends Model
{
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
     *      title="Value",
     *      description="Value of the transaction",
     *      format="double",
     *      example="1000.00"
     * )
     *
     * @var number
     */
    private $value;

    /**
     * @OA\Property(
     *      title="User ID",
     *      description="User of the transaction",
     *      format="int64",
     *      example="1"
     * )
     *
     * @var integer
     */
    private int $user_id;

    /**
     * @OA\Property(
     *      title="Type Transaction",
     *      description="Type of the transaction",
     *      format="int64",
     *      example="1"
     * )
     *
     * @var integer
     */
    private int $transaction_type_id;

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
        'value',
        'user_id',
        'transaction_type_id',
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
     * Transação pertence a um único usuário
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Transação pertence a um único tipo
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id', 'id');
    }

    /**
     * Filtros de perídos
     *
     * @param Builder $builder
     * @param array $filters
     * @return Builder
     */
    public function scopeFilter(Builder $builder, array $filters = [])
    {
        if(empty($filters)) {
            return $builder;
        }

        if($filters['type'] == 1) {
            $builder->whereDate('created_at', '>', Carbon::now()->subDays(30));
        } else if($filters['type'] == 2) {
            $date = explode('/', $filters['period']);
            $builder
                ->whereMonth('created_at', $date[0])
                ->whereYear('created_at', $date[1]);
        }

        return $builder;
    }
}
