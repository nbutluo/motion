<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Blog\Blog;
use App\Model\Blog\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends ApiController
{
    public function getList(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $data = app(Blog::class)->getPageList($page, $pageSize);

        if ($data) {
            return $this->success('success', $data);
        } else {
            return $this->fail('failure', 500, []);
        }
    }

    public function getDetail($post_id)
    {
        $data = app(Blog::class)->getSelectFind($post_id);
        return $this->success('success', $data);
    }

    // 获取分类列表
    public function getCategoryList()
    {
        $data = app(BlogCategory::class)->getCategoriesInHome();
        return $this->success('success', $data);
    }

    // 获取对应分类下博客内容
    public function getCategoriesBlog(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);

        $category_id = $request->input('category_id');
        $data = app(Blog::class)->getCategoryPostList($category_id, $page, $pageSize);

        if ($data) {
            return $this->success('success', $data);
        } else {
            return $this->fail('failure', 500, []);
        }
    }
}
