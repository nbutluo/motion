<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Permission;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function layout()
    {
        //左侧菜单
        $menus = Permission::with(['childsMenus'])->where('parent_id',0)->orderBy('sort','asc')->get();
//        echo '<pre>';var_dump($menus->toArray());
        //获取所有菜单名称
        $menu_names = Permission::where('route','!=','')->where('is_menu',1)->select('route','display_name')->get()
            ->map(function ($item,$key) {
                $item['url'] = route($item['route']);
                return $item;
            })->keyBy('route')->toArray();
//        var_dump($menu_names);

        return view('admin.layout',['menus' => $menus, 'menu_names' => json_encode($menu_names)]);

    }

    public function index()
    {
        return view('admin.index.index');
    }
}
