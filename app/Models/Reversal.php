<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reversal extends Model
{
    use HasFactory;

    protected $fillable = [
        'valor_estorno',
        'credit_id',
        'debit_id',
        'account_id'
    ];


    public function debito()
    {
        return $this->hasMany(Debit::class, 'debit_id');
    }

    public function credito()
    {
        return $this->hasMany(Credit::class, 'credit_id');
    }

    public function account()
    {
        return $this->hasMany(Account::class, 'account_id');
    }

}
