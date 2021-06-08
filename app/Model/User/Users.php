<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    use SoftDeletes;
    protected $table = 'users';
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $fillable = ['username','password','nickname','user_level','avatar','sex','birth','email','phone','country','province','city','area','company_url','api_token','salesman'];
}
