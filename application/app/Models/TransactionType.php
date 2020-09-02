<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="TransactionType",
 *     description="TransactionType Model",
 * )
 */
class TransactionType extends Model
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
     *      title="Title",
     *      description="User of the transaction type",
     *      example="Crédito"
     * )
     *
     * @var string
     */
    private string $title;

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

    const TYPE = [
        1 => 'credit',
        2 => 'debit',
        3 => 'reversal',
    ];

    protected $fillable = [
      'title'
    ];
}
