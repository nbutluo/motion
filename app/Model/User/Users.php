<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $fillable = ['nickname','avatar','sex','birth','email','phone','country','province','city','area','company_url'];
}
