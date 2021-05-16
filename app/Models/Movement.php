<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Movement extends Model
{
    use HasFactory;

    protected $table = 'movements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'operation',
        'value',
        'user_id',
    ];  

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getValueformatAttribute(){
        return number_format($this->value,2,",",".");
    }

    public static function filter($request,$user_id){
        $movements = new Movement();     
        $movements = $movements->where('user_id',$user_id);
        
        switch ($request->type) {
            case 'last_30_days':
                return $movements->last30Days()->get(); 
                break;
            case 'by_date':
                $data = explode('/',$request->date);
                return $movements->byMonthYear($data[0],$data[1])->get(); 
                break; 
            case 'all':
            default:
                return $movements->orderBy('created_at')->get(); 
                break;
        }
    }

    public function scopeByMonthYear($query,$month,$year)
    {
        return $query->whereMonth('created_at', $month)->whereYear('created_at',$year)->orderBy('created_at');
    }

    public function scopeLast30Days($query)
    {
        return $query->whereDate('created_at', '>' , Carbon::now()->subDays(30))->orderBy('created_at');
    }

}
