<?php

namespace App\Model\Config;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Config\Configuration
 *
 * @property int $id
 * @property int $group_id 所属组
 * @property string $label 配置项名称
 * @property string $key 配置项键值
 * @property string $val 配置项值
 * @property string $type 配置项类型，input输入框，radio单选，select下拉,image单图片
 * @property string|null $content 配置项类型的内容
 * @property string|null $tips 输入提示
 * @property int $sort 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereTips($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereVal($value)
 * @mixin \Eloquent
 */
class Configuration extends Model
{
    protected $table = 'configuration';
}
