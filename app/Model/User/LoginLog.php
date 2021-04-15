<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_logs';
    protected $fillable = ['uid'];
}
