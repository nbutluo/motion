<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\Categories;
use App\Model\MenuCategory;
use Exception;
use App\Http\Controllers\ApiController;

class MenuCategoryController extends ApiController
{
    public function getCategories()
    {
        try {
            $data = [];
            $categories = MenuCategory::where('status', 1)->orderBy('parent_id', 'ASC')->orderBy('sort', 'ASC')->get();
            foreach ($categories as $category_key => $category) {
                $newData = [];
                if ($category->parent_id == 0) {
                    $newData['category_name'] = $category->category_name;
                    $newData['sort'] = $category->sort;
                    foreach ($categories as $category_title) {
                        $list2 = [];
                        if ($category_title->parent_id == $category->id) {
                            $list2['title'] = $category_title->category_name;
                            $list2['sort'] = $category_title->sort;
                            $list3 = [];
                            foreach ($categories as $category_label) {
                                if ($category_label->parent_id == $category_title->id) {
                                    $list3[] = [
                                        'label' => $category_label->category_name,
                                        'sort' => $category_label->sort,
                                    ];
                                }
                            }
                            (!empty($list3)) ? $list2['child'] = $list3 : '';
                            $newData['child'][] = $list2;
                        }
                    }
                    $data[] = $newData;
                }
            }

            return $this->success('获取成功', $data);
        } catch (Exception $e) {
            return $this->fail('程序异常，获取失败。', 500);
        }
    }
}
