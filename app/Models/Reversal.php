<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reversal extends Model
{
    use HasFactory;

    protected $fillable = [
        'valor',
        'credit_id',
        'debit_id',
    ];
}
