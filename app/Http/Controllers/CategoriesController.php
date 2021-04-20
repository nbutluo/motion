<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Categories;

class CategoriesController extends Controller
{
    public function getCategories()
    {
        $data = [];
        $categories = Categories::where('status',1)->orderBy('parent_id','ASC')->orderBy('sort','ASC')->get();
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
        return response()->json($data);
    }
}
