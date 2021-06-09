<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moviment extends Model
{
    use HasFactory;

    protected $fillable = [
        "financial_id",
        "moviment_type_id",
        "value",
    ];

    public function type()
    {
        return $this->belongsTo(MovimentType::class);
    }
}
