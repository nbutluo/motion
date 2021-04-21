<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\Categories;
use Exception;
use App\Http\Controllers\ApiController;

class CategoriesController extends ApiController
{
    public function getCategories()
    {
        try {
            $data = [];
            $categories = Categories::where('status', 1)->orderBy('parent_id', 'ASC')->orderBy('sort', 'ASC')->get();
            foreach ($categories as $category_key => $category) {
                if ($category->parent_id == 0) {
                    $data[$category->id]['category_name'] = $category->category_name;
                    $data[$category->id]['sort'] = $category->sort;
                    foreach ($categories as $category_title) {
                        if ($category_title->parent_id == $category->id) {
                            $data[$category->id][$category_title->id]['title'] = $category_title->category_name;
                            $data[$category->id][$category_title->id]['sort'] = $category_title->sort;
                            foreach ($categories as $category_label) {
                                if ($category_label->parent_id == $category_title->id) {
                                    $data[$category->id][$category_title->id][] = [
                                        'label' => $category_label->category_name,
                                        'sort' => $category_label->sort,
                                    ];
                                }
                            }
                        }
                    }
                }
            }

            return $this->success('获取成功', $data);
        } catch (Exception $e) {
            return $this->fail('程序异常，获取失败。', 500);
        }
    }
}
