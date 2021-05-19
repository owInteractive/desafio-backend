<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Credit;
use App\Models\Debit;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'saldo',
        'user_id'
    ];
    
    public function debito()
    {
        return $this->hasMany(Debit::class);
    }

    public function credito()
    {
        return $this->hasMany(Credit::class);
    }
}
