<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Model\Blog\Blog;
use App\Model\SystemConfig;
use Illuminate\Http\Request;

class BlogController extends AdminController
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

    public function getPost($post_id)
    {
        $data = app(Blog::class)->getFind($post_id);
        return $this->success('success', $data);
    }

    public function addPost(Request $request)
    {
        $content = $request->input('content', '');
        $is_active = $request->input('is_active', 0);
        $title = $request->input('title', '');
        if (empty($title)) {
            return $this->fail('参数错误，缺少博客标题', 4001);
        }
        $params = [
            'title' => $title,
            'content' => $content,
            'publish_time' => date('Y-m-d H:i:s'),
            'is_active' => $is_active,
        ];

        $data = app(Blog::class)->addPost($params);

        if ($data) {
            return $this->success('success', $data);
        } else {
            return $this->fail('failure', 500, []);
        }
    }

    public function updatePost(Request $request)
    {
        $id = $request->input('post_id');
        if (empty($id)) {
            return $this->fail('参数错误，缺少博客ID', 4001);
        }

        $params = [];
        if ($content = $request->input('title')) {
            $params['title'] = $content;
        }
        if ($content = $request->input('content')) {
            $params['content'] = $content;
        }
        if ($content = $request->input('is_active')) {
            $params['is_active'] = $content;
        }
        if ($content = $request->input('show_in_home')) {
            $params['show_in_home'] = $content;
        }

        $data = app(Blog::class)->updatePost($id, $params);

        if ($data) {
            return $this->success('更新成功');
        } else {
            return $this->fail('failure', 500);
        }
    }




}
