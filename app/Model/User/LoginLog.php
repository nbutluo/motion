<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\User\LoginLog
 *
 * @property int $id
 * @property int $uid 用户id
 * @property string $ip 登录IP地址
 * @property string $method 请求方式
 * @property string $user_agent UserAgent
 * @property string $message 登录状态信息
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereUserAgent($value)
 * @mixin \Eloquent
 */
class LoginLog extends Model
{
    protected $table = 'login_logs';
    protected $fillable = ['uid'];
}
