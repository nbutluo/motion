<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\MediumSourceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class MediumSourceCategoryController extends AdminController
{
    public function index()
    {
        return view('admin.medium-category.index');
    }

    public function categoryData ()
    {
        $categoriesData = [];
        $allCategories = MediumSourceCategory::select(['id','name','parent_id','identity'])->get();
        foreach ($allCategories as $allCategory) {
            $categoriesData[$allCategory->id] = $allCategory->toArray();
        }
        $allCateData = [];
        foreach ($categoriesData as $cateData) {
            $data = [];
            if ($cateData['parent_id'] == 0) {
                $data['title'] = $cateData['name'];
                $data['id'] = $cateData['id'];
                foreach ($categoriesData as $key_first => $firstCategory) {
                    $firstData = [];
                    if ($firstCategory['parent_id'] == $cateData['id']) {
                        $firstData['title'] = $firstCategory['name'];
                        $firstData['id'] = $firstCategory['id'];
                        $secondData = [];
                        foreach ($categoriesData as $key_second => $secondCategory) {
                            $thirdData = [];
                            if ($secondCategory['parent_id'] == $firstCategory['id']) {
                                $thirdData['title'] = $secondCategory['name'];
                                $thirdData['id'] = $secondCategory['id'];
                                $secondData[] = $thirdData;
                            }
                        }
                        $firstData['children'] = $secondData;
                        $data['children'][] = $firstData;
                    }
                }
                $allCateData[] = $data;
            }
        }
        return $allCateData;
    }

    public function getList(Request $request)
    {
        $category = [];
        $allCategories = MediumSourceCategory::select(['id','name'])->get();
        foreach ($allCategories as $allCategory) {
            $category[$allCategory->id] = $allCategory->name;
        }
        $mediumCategories = MediumSourceCategory::paginate($request->get('limit',90));
        foreach ($mediumCategories as $mediumCategory) {
            if ($mediumCategory->parent_id == 0) {
                $mediumCategory->parent_id = '一级分类';
            } else {
                $mediumCategory->parent_id = $category[$mediumCategory->parent_id];
            }
        }
        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $mediumCategories->total(),
            'data' => $mediumCategories->items()
        ];
        return Response::json($data);
    }

    public function create()
    {
        $categories = $this->categoryData();
        return view('admin.medium-category.create',compact('categories'));
    }

    public function add(Request $request)
    {
        try {
            $date = [];
            $data['name'] = $request->category_name;
            $data['parent_id'] = $request->category_parent_id;
            $data['is_active'] = $request->is_active;
            if ($request->category_parent_id == 0) {
                $data['identity'] = 0;
            } else {
                $category = MediumSourceCategory::select(['id','identity'])->findOrFail($request->category_parent_id);
                $data['identity'] = $category->identity.'-'.$request->category_parent_id;
            }
            MediumSourceCategory::create($data);
            return redirect::to(URL::route('admin.medium.category.index'))->with(['success' => '添加成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }

    public function edit($id)
    {
        $categories = $this->categoryData();
        $mediumCategory = MediumSourceCategory::findOrFail($id);
        return view('admin.medium-category.edit',compact('id','mediumCategory','categories'));
    }

    public function update(Request $request)
    {
        try {
            $category = MediumSourceCategory::findOrFail($request->id);
            $params = [];
            $params['name'] = $request->category_name;
            $params['parent_id'] = $request->category_parent_id;
            $params['is_active'] = $request->is_active;
            if ($request->category_parent_id == 0) {
                $params['identity'] = 0;
            } else {
                $parentCategory = MediumSourceCategory::select(['id','identity'])->findOrFail($request->category_parent_id);
                $params['identity'] = $parentCategory->identity.'-'.$request->category_parent_id;
            }
            $category->update($params);
            return redirect::to(URL::route('admin.medium.category.index'))->with(['success' => '修改成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }
}
