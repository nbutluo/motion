<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'name',  'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // 验证密码
    public function verifyPassword($password)
    {
        return Hash::check($password, $this->password);
    }

    public function verifyName($name)
    {
        return $this->where(['name' => $name]);
    }
}
