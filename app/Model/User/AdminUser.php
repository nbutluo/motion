<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class AdminUser extends Model
{
    use HasRoles;
    protected $table = 'admin_users';
}
