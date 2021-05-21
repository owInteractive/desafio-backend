<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    use HasFactory;

    public $table = "movimentacoes";

    protected $fillable = [
       
        'valor',
        'user_id',
        'nome_movimentacao'
 
    ];

}
