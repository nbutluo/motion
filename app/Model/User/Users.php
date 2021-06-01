<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $fillable = ['username','password','nickname','avatar','sex','birth','email','phone','country','province','city','area','company_url','api_token'];
}
