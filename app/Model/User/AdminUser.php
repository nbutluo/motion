<?php

namespace App\Model\User;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUser extends Authenticatable
{
    use HasRoles,SoftDeletes;
    protected $table = 'admin_users';
    protected $datas = ['deleted_at'];

    protected $fillable = [
        'username','nickname', 'email', 'password','phone','api_token','remember_token','rule_id'
    ];
}
