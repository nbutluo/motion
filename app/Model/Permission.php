<?php

namespace App\Model;

use Illuminate\Support\Arr;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected $appends = ['type_name'];

    public function getTypeNameAttribute()
    {
        return $this->attributes['type_name'] = Arr::get([1=>'按钮',2=>'菜单'],$this->type);
    }

    //子权限
    public function childs()
    {
        return $this->hasMany('App\Model\Permission','parent_id','id');
    }

    //子权限（是菜单的）
    public function childsMenus()
    {
        return $this->hasMany('App\Model\Permission','parent_id','id')->where('is_menu', 1);
    }

    //所有子权限递归
    public function allChilds()
    {
        return $this->childs()->with('allChilds');
    }
}
