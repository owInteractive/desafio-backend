<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = ['id_user', 'id_transaction_type', 'id_status_type', 'value', 'authorization'];
}
