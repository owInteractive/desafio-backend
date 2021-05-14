<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthday'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'api_token', 'password', 'deleted_at'
    ];

    public function setBirthdayAttribute($value)
    {
        $date = DateTime::createFromFormat('d/m/Y', $value);
        $this->attributes['birthday'] = $date->format('Y-m-d');
    }

    public function setPasswordAttribute($newPassword)
    {
        $this->attributes['password'] = Hash::make($newPassword);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->api_token = Str::random(60);
        });
    }
}
