<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Blog\Blog;
use App\Model\Blog\BlogCategory;
use App\Model\Sitemap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class BlogCategoryController extends AdminController
{

    public function index()
    {
        return view('admin.blog-category.index');
    }

    public function getList(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);

        $res = app(BlogCategory::class)->getPageList($page, $limit);

        return response()->json([
            'code' => 0,
            'msg' => '获取成功',
            'count' => $res['total'],
            'data' => $res['list'],
        ]);
    }

    public function create()
    {
        //分类
        $categories = BlogCategory::orderBy('position', 'asc')->get();

        return view('admin.blog-category.create', compact('categories'));
    }

    public function getCategory($post_id)
    {
        $data = app(BlogCategory::class)->getFind($post_id);
        return $this->success('success', $data);
    }

    public function addCategory(Request $request)
    {
        $title = $request->input('title', '');
        if (empty($title)) return redirect::back()->withErrors('参数错误，缺少分类标题');

        $params = [
            'title' => $title,
            'keywords' => $request->input('keywords', ''),
            'content' => $request->input('content', ''),
            'is_active' => $request->input('is_active', 0),
            'position' => $request->input('position', '0')
        ];
        $siteMap = [
            'type' => 9,
            'methed' => 1,
            'name' => 'blog分类',
            'url' => '/blogs/' . str_replace(' ', '-', $title),
            'origin' => '/loctek/category/blog-list'
        ];
        try {
            app(BlogCategory::class)->addCategory($params);
            Sitemap::create($siteMap);
            return redirect::to(URL::route('admin.blog.category'))->with(['success' => '添加成功']);
        } catch (\Exception $exception) {
            return redirect::back()->withErrors('添加失败');
        }
    }

    public function edit($id)
    {
        //分类
        $category = BlogCategory::findOrFail($id);

        return view('admin.blog-category.edit', compact('category'));
    }

    public function update($id, Request $request)
    {
        if (empty($id)) return redirect::back()->withErrors('参数错误，缺少分类ID');

        $params = [];
        if ($content = $request->input('title')) {
            $params['title'] = $content;
        }
        if ($content = $request->input('content')) {
            $params['content'] = $content;
        }

        $params['include_in_menu'] = $request->input('include_in_menu', 1);
        $params['is_active'] = $request->input('is_active', 1);

        try {
            app(BlogCategory::class)->updateCategory($id, $params);
            return redirect::to(URL::route('admin.blog.category'))->with(['success' => '更新成功']);
        } catch (\Exception $exception) {
            return redirect::back()->withErrors('更新失败');
        }
    }

    public function disable(Request $request)
    {
        $ids = $request->input('ids');
        if (empty($ids)) return $this->fail('参数错误，缺少ID', 4001);

        $status = (int)$request->input('status', 0);

        try {
            app(BlogCategory::class)->updateActiveStatus($ids, $status);
            return response()->json(['code' => 0, 'msg' => '状态修改成功']);
        } catch (\Exception $e) {
            return response()->json(['code' => 1, 'msg' => '状态修改失败', 'data' => $e->getMessage()]);
        }
    }
}
