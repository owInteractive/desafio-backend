<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movimentacao extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'movimentacoes';

    protected $fillable = [
        'operacao',
        'user_id',
        'valor',
    ];


    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
