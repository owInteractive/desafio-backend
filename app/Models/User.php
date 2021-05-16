<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'birthday',
        'password',
        'opening_balance'
    ];  

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
