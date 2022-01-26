<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Product\Category;
use App\Model\Product\Product;
use App\Model\Sitemap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class ProductCategoryController extends AdminController
{
    public function index()
    {
        return view('admin.product-category.index');
    }

    public function getList(Request $request)
    {
        $category = Category::paginate($request->get('limit', 90));
        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $category->total(),
            'data' => $category->items()
        ];
        return Response::json($data);
    }

    public function create()
    {
        $categories = Category::where('level', 1)->where('is_active', 1)->orderBy('position', 'asc')->get();
        return view('admin.product-category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $level = ($data['parent_id'] == 0) ? 1 : 2;
        $categoryData = [];
        $categories = Category::select(['id', 'name'])->get();
        foreach ($categories as $cate) {
            $categoryData[$cate->id] = $cate->name;
        }
        try {
            Category::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'parent_id' => $data['parent_id'],
                'level' => $level,
                'is_active' => $data['is_active'],
                'position' => $data['position'],
            ]);
            //添加siteMap
            $siteMap = [
                'type' => 7,
                'methed' => 1,
                'name' => '产品分类链接',
                'url' => ($data['parent_id'] == 0) ? '/' . str_replace(' ', '-', $data['name']) : '/' . str_replace(' ', '-', $categoryData[$data['parent_id']]) . '/' . str_replace(' ', '-', $data['name']),
                'origin' => '/loctek/product/list'
            ];
            Sitemap::create($siteMap);
            return Redirect::to(URL::route('admin.catalog.category'))->with(['success' => '添加成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        $categories = Category::where('level', 1)->where('is_active', 1)->get();
        return view('admin.product-category.edit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->only(['name', 'position', 'parent_id', 'description', 'is_active', 'meta_title', 'meta_description', 'meta_keywords']);
        $data['level'] = ($data['parent_id'] != 0) ? 2 : 1;
        try {
            $category->update($data);
            return Redirect::to(URL::route('admin.catalog.category'))->with(['success' => '更新成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors('更新失败');
        }
    }

    public function getCategoryData(Request $request, Category $category, Product $product)
    {
        $categories = Category::select(['id', 'name', 'parent_id'])->where('is_active', true)->where('level', 2)->get();

        $top_categories = Category::select(['id', 'name'])->where('is_active', true)->where('level', 1)->get();

        $product_category_ids = explode(',', $product->category_id);

        $arr = [];
        foreach ($top_categories as $key => $top_category) {
            $filtered = $categories->filter(function ($category) use ($top_category, $product_category_ids) {
                if ($category->parent_id == $top_category->id) {
                    $category['selected'] = in_array($category->id, $product_category_ids) ? true : false;
                    $category['value'] = $category->id;
                    return $category;
                }
            })->toArray();

            // 如果顶级分类下没有子分类，则跳过
            if (count($filtered) == 0) {
                continue;
            }

            $arr[$key]['name'] = $top_category->name;
            $arr[$key]['children'] = array_values($filtered);
        }

        $data = [
            'code' => 1,
            'data' => $arr,
        ];

        return Response::json($data);
    }
}
