<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transitions extends Model
{
    use HasFactory;

    protected $with = ['user'];

    protected $fillable = [
        'types',
        'user_id',
        'value',
    ];

    /**
     * define relationship between user and transitions
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * casting transition value
     */
    public function setValueAttribute($value)
    {   
        $this->attributes['value'] = (string) $value;
    }

    public function getFromDays($days)
    {   
        $endDate = Carbon::now()->format('Y-m-d') . ' 23:59:59';
        $startDate = Carbon::now()->subDays($days)->format('Y-m-d') . ' 00:00:00';

        $data = self::whereBetween('created_at', [$startDate,$endDate])->get();

        return $data;
    }

    public function getFromMouthYear($mouthYear) 
    {   
        $mouthYear = explode('/', $mouthYear);
        $mouth = (int) $mouthYear[0];
        $year =  (int) '20'. $mouthYear[1];

        $data = self::whereMonth('created_at', $mouth)
            ->whereYear('created_at', $year)
            ->get();

        return $data;
    }
}
