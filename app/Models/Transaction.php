<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Transaction extends Model
{
    use UsesUuid;

    protected $fillable = [
        'amount',
        'transaction_type',
        'user_id',
    ];

    public function getAmountAttribute($value){
        return $value / 100;
    }

    public function setAmountAttribute($value){
        $this->attributes['amount'] = $value * 100;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
