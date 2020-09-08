<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationType extends Model
{
    public function operations(){
        return $this->belongsTo(Operation::class);
    }
}