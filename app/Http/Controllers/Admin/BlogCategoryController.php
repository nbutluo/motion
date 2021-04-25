<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Blog\Blog;
use App\Model\Blog\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends AdminController
{

    public function getList(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $data = app(BlogCategory::class)->getPageList($page, $pageSize);

        if ($data) {
            return $this->success('success', $data);
        } else {
            return $this->fail('failure', 500, []);
        }
    }

    public function getCategory($post_id)
    {
        $data = app(BlogCategory::class)->getFind($post_id);
        return $this->success('success', $data);
    }

    public function addCategory(Request $request)
    {
        $content = $request->input('content', '');
        $is_active = $request->input('is_active', 0);
        $title = $request->input('title', '');
        if (empty($title)) {
            return $this->fail('参数错误，缺少博客分类标题', 4001);
        }
        $params = [
            'title' => $title,
            'content' => $content,
            'is_active' => $is_active,
        ];

        $data = app(Blog::class)->addPost($params);

        if ($data) {
            return $this->success('success', $data);
        } else {
            return $this->fail('failure', 500, []);
        }
    }

    public function updateCategory(Request $request)
    {
        $id = $request->input('category_id');
        if (empty($id)) {
            return $this->fail('参数错误，缺少博客分类ID', 4001);
        }

        $params = [];
        if ($content = $request->input('title')) {
            $params['title'] = $content;
        }
        if ($content = $request->input('content')) {
            $params['content'] = $content;
        }
        if ($content = $request->input('include_in_menu')) {
            $params['include_in_menu'] = $content;
        }

        $data = app(Blog::class)->updatePost($id, $params);

        if ($data) {
            return $this->success('更新成功');
        } else {
            return $this->fail('failure', 500);
        }
    }
}
