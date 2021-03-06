<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    // 查询用户等级
    public function level($value)
    {
        return  $this->where('level', $value);
    }

    // 查询授权申请状态
    public function applyStatus($value)
    {
        return $this->where('apply_status', $value);
    }
}
