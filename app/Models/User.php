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
    ];  

    //hasmany to movement

}
