<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Product\Category;
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
        $category = Category::paginate($request->get('limit', 30));
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
        $categories = Category::where('level', 1)->orderBy('position', 'asc')->get();
        return view('admin.product-category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $level = ($data['parent_id'] == 0) ? 1 : 2;
        try {
            Category::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'parent_id' => $data['parent_id'],
                'level' => $level,
                'is_active' => $data['is_active'],
                'position' => $data['position'],
            ]);
            return Redirect::to(URL::route('admin.catalog.category'))->with(['success' => '添加成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if ($category->parent_id != 0) {
            $parent = Category::find($category->parent_id);
            $parent_name = $parent->name;
        } else {
            $parent_name = '一级分类';
        }
        return view('admin.product-category.edit',compact('category','parent_name'));
    }

    public function update(Request $request,$id)
    {
        $category = Category::findOrFail($id);
        $data = $request->only(['name','position','description','is_active']);
        try {
            $category->update($data);
            return Redirect::to(URL::route('admin.catalog.category'))->with(['success' => '更新成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors('更新失败');
        }
    }
}
