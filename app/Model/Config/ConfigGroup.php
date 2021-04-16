<?php

namespace App\Model\Config;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Config\ConfigGroup
 *
 * @property int $id
 * @property string $name 名称
 * @property int $sort 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigGroup whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ConfigGroup extends Model
{
    protected $table = 'config_group';
}
