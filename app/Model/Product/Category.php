<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;

//use Illuminate\Pagination\Paginator;

class Category extends Model
{
    protected $table = 'catalog_category';
    protected $primaryKey = 'id';

    public function getCategoryList()
    {
        $first = Category::select('id', 'name', 'parent_id', 'position', 'description')->where('level', 1)->orderBy('position', 'desc')->get();

        foreach ($first as $k1 => &$first_v) {
            $second = Category::select('id', 'name', 'parent_id', 'position', 'description')
                ->where('level', 2)->where('parent_id', $first_v->id)
                ->orderBy('position', 'desc')->get();
            foreach ($second as $k2 => &$second_v) {
                $third = Category::select('id', 'name', 'parent_id', 'position', 'description')
                    ->where('level', 3)->where('parent_id', $second_v->id)
                    ->orderBy('position', 'desc')->get();
                $second_v['child'] = $third;
            }
            $first_v['child'] = $second;
        }

        $product_menu = $first;

        return $product_menu;
    }
}
