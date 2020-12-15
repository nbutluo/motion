<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Level;

class User extends Authenticatable
{
    use Notifiable;


    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 根据传入的 用户 level 返回 Level模型中对应的 用户等级名称 
    public function level_name($user_level)
    {
        $levels = Level::get();
        foreach ($levels as  $level) {
            if ($user_level == $level->value) {
                return $level->name;
            }
        }
    }

    public function status($email_verified_at)
    {
        return $email_verified_at ? '已认证' : '未认证';
    }


    /**
     * 返回未认证的用户数
     */
    public function inactivateds()
    {
        return $this->whereNull('email_verified_at', '')->count();
    }

    /**
     * 返回已认证的用户数
     */
    public function activateds()
    {
        return $this->where('email_verified_at', '!=', 'null')->count();
    }
}
