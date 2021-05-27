<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Blog\Blog;
use App\Model\Blog\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class BlogController extends AdminController
{

    public function index()
    {
        $categories = BlogCategory::where('is_active', 1)->orderBy('position', 'asc')->get();
        return view('admin.blog.index', compact('categories'));
    }

    public function getList(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);

        $res = app(Blog::class)->getPageList($page, $limit);
        foreach ($res['list'] as $re) {
            if (isset($re->category_id) && !empty($re->category_id) && $re->category_id != 0) {
                $category = BlogCategory::findOrFail($re->category_id);
                $re->category_id = $category->title;
            }
        }

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
        $categories = BlogCategory::where('is_active', 1)->orderBy('position', 'asc')->get();

        return view('admin.blog.create', compact('categories'));
    }

    public function getPost($post_id)
    {
        $data = app(Blog::class)->getFind($post_id);
        return $this->success('success', $data);
    }

    public function addPost(Request $request)
    {
        $content = $request->input('content', '');
        $short_content = $request->input('short_content', '');
        $is_active = $request->input('is_active', 0);
        $title = $request->input('title', '');
        if (empty($title)) return redirect::back()->withErrors('添加失败，缺少标题');
        $image = $request->input('featured_img');
        $params = [
            'title' => $title,
            'content' => $content,
            'short_content' => $short_content,
            'publish_time' => date('Y-m-d H:i:s'),
            'is_active' => $is_active,
            'featured_img' => $image,
        ];

        if ($category_id = $request->input('category_id')) {
            $params['category_id'] = $category_id;
        }
        if ($keywords = $request->input('keywords')) {
            $params['keywords'] = $keywords;
        }

        try {
            app(Blog::class)->addPost($params);
            return redirect::to(URL::route('admin.blog.article'))->with(['success' => '添加成功']);
        } catch (\Exception $exception) {
            return redirect::back()->withErrors('添加失败');
        }
    }

    public function edit($id)
    {
        //文章
        $post = Blog::findOrFail($id);
        //分类
        $categories = BlogCategory::where('is_active', 1)->orderBy('position', 'asc')->get();

        return view('admin.blog.edit', compact('post', 'categories'));
    }

    public function update($id, Request $request)
    {
        if (empty($id)) return redirect::back()->withErrors('参数错误，缺少ID');

        $params = [];
        if ($title = $request->input('title')) {
            $params['title'] = $title;
        }
        if ($content = $request->input('content')) {
            $params['content'] = $content;
        }
        if ($short_content = $request->input('short_content')) {
            $params['short_content'] = $short_content;
        }
        if ($category_id = $request->input('category_id')) {
            $params['category_id'] = $category_id;
        }
        if ($keywords = $request->input('keywords')) {
            $params['keywords'] = $keywords;
        }
        if ($image = $request->input('featured_img')) {
            $params['featured_img'] = $image;
        }

        // 首页显示状态 1、是 2、否
        $params['show_in_home'] = $request->input('show_in_home', 1);
        $params['is_active'] = $request->input('is_active', 1);

        try {
            app(Blog::class)->updatePost($id, $params);
            return redirect::to(URL::route('admin.blog.article'))->with(['success' => '更新成功']);
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
            app(Blog::class)->updateActiveStatus($ids, $status);
            return response()->json(['code' => 0, 'msg' => '状态修改成功']);
        } catch (\Exception $e) {
            return response()->json(['code' => 1, 'msg' => '状态修改失败', 'data' => $e->getMessage()]);
        }
    }


}
