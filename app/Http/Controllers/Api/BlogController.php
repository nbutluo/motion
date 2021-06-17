<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Blog\Blog;
use App\Model\Blog\BlogCategory;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class BlogController extends ApiController
{
    public function getList(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $data = app(Blog::class)->getPageList($page, $pageSize);
        foreach ($data['list'] as $list) {
            if (isset($list->featured_img) && !empty($list->featured_img)) {
                $list->featured_img = HTTP_TEXT.$_SERVER["HTTP_HOST"].$list->featured_img;
            }
        }

        if ($data) {
            return $this->success('success', $data);
        } else {
            return $this->fail('failure', 500, []);
        }
    }

    public function getDetail($post_id)
    {
        $data = app(Blog::class)->getSelectFind($post_id);
        if(isset($data['featured_img']) && !empty($data['featured_img'])) {
            $data['featured_img'] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$data['featured_img'];
        }
        return $this->success('success', $data);
    }

    // 获取分类列表
    public function getCategoryList()
    {
        $data = app(BlogCategory::class)->getCategoriesInHome();
        return $this->success('success', $data);
    }

    public function getCategoryId($categoryName)
    {
        $categories = BlogCategory::select(['category_id'])->where('title',$categoryName)->first();
        return $categories['category_id'];
    }

    // 获取对应分类下博客内容
    public function getCategoriesBlog(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $pageSize = $request->input('pageSize', 10);

            $category_name = $request->category_name;
            $category_id = $this->getCategoryId($category_name);
            if (!isset($category_id)) {
                throw new \Exception('category name is wrong!');
            }
            $data = app(Blog::class)->getCategoryPostList($category_id, $page, $pageSize);
            if (!empty($data['list'])) {
                foreach ($data['list'] as $item) {
                    if (isset($item->featured_img) && !empty($item->featured_img)) {
                        $item->featured_img = HTTP_TEXT.$_SERVER["HTTP_HOST"].$item->featured_img;
                    }
                }
            }
            return $this->success('success', $data);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 500, []);
        }
    }

    //获取新帖子
    public function getNewBlog()
    {
        try {
            $news = Blog::select(['post_id','title','featured_img'])->orderBy('created_at','desc')->where('is_active',1)->limit(4)->get();
            foreach ($news as $new) {
                if (isset($new->featured_img) && $new->featured_img) {
                    $new->featured_img = HTTP_TEXT.$_SERVER["HTTP_HOST"].$new->featured_img;
                }
            }
            return $this->success('success', $news);
        } catch (\Exception $exception) {
            return $this->fail('failure', 500, []);
        }
    }

    //获取最近更新帖子
    public function lastUpdate()
    {
        try {
            $news = Blog::select(['post_id','title','featured_img','short_content','content'])->where('is_active',1)->orderBy('updated_at','desc')->limit(3)->get();
            foreach ($news as $new) {
                if (isset($new->featured_img) && $new->featured_img) {
                    $new->featured_img = HTTP_TEXT.$_SERVER["HTTP_HOST"].$new->featured_img;
                }
            }
            return $this->success('success', $news);
        } catch (\Exception $exception) {
            return $this->fail('failure', 500, []);
        }
    }

    //获取相关文章
    public function relateBlog($id)
    {
        try {
            $blog = Blog::select(['post_id','title','relate_id','featured_img','short_content','content'])->where('is_active',1)->where('post_id',$id)->first();
            if (isset($blog->relate_id) && $blog->relate_id !='') {
                $relates = explode(',',$blog->relate_id);
            }
            $news = Blog::select(['post_id','title','featured_img','short_content','content'])->where('is_active',1)->whereIn('post_id',$relates)->get();
            foreach ($news as $new) {
                if (isset($new->featured_img) && $new->featured_img) {
                    $new->featured_img = HTTP_TEXT.$_SERVER["HTTP_HOST"].$new->featured_img;
                }
            }
            return $this->success('success', $news);
        } catch (\Exception $exception) {
            return $this->fail('failure', 500, []);
        }
    }
}
