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
    protected $fillable = [
        'name'
    ];
}
