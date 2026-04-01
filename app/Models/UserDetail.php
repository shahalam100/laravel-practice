<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{   
    //(Mass Assignment)
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'password',
        'skills',
        'docs',
        'phone',
        'country',
    ];
}
