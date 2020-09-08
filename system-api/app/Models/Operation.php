<?php

namespace App\Models;

use App\Models\OperationType;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = [
        'user_id','operation_type_id','amount'
    ];

    public function operationType(){
        return $this->hasOne(OperationType::class);
    }
}
