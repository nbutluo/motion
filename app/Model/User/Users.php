<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\User\Users
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $nickname
 * @property int $user_leverl 用户等级：0普通用户，1一级用户，2二级用户
 * @property int $sex 性别：0女，1男
 * @property string $birth 生日
 * @property string $email email
 * @property string $phone
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $company_url
 * @property string|null $remember_token
 * @property string $api_token
 * @property string|null $deleted_at
 * @property string $last_login 上次登录时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Users newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Users newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Users query()
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereCompanyUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereUserLeverl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereUsername($value)
 * @mixin \Eloquent
 */
class Users extends Model
{
    protected $table = 'users';
    protected $hidden = [
        'password', 'remember_token',
    ];
}
