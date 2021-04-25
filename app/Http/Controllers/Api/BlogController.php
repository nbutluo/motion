<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Blog\Blog;
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
}
