<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;

class User extends Model
{ 
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'birthday',
        'opening_balance'
    ];  
 
    public function movements()
    {
        return $this->hasMany(Movement::class,'user_id');
    }

    public function history_movements(){
        return $this->movements()->orderBy('movements.created_at','DESC')->get();
    }

    public function actual_balance($init_balance){
        $itens = $this->movements()->orderBy('movements.created_at','ASC')->get();
        $total = $init_balance;
        if(!empty($itens)){
            foreach($itens as $item){
                switch ($item->operation) {
                    case 'credit':
                        $total += $item->value; 
                        break;
                    case 'debit':
                        $total -= $item->value;   
                        break;
                    case 'reversal':
                        $total += $item->value;   
                        break; 
                }
            }
        };
        return number_format($total,2,",",".");
    }
}
