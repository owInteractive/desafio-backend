<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'birthday', 'balance'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

}
