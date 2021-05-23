<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "opening_balance",
        "current_balance",
    ];

    public function user()
    {
        return $this->belongsTo(User¨::class);
    }

    public function moviments()
    {
        return $this->hasMany(Moviment::class);
    }
}
