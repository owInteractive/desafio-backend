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
    const TRANSACTION_TYPE = [
        1 => 'Crédito',
        2 => 'Débito',
        3 => 'Estorno',
    ];

    protected $fillable = [
        'title'
    ];
}
