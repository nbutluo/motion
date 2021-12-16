<?php

namespace App\Http\Controllers\Admin;

use App\Handlers\Base64ImageHandler;
use App\Http\Controllers\AdminController;
use App\Http\Requests\BlogRequest;
use App\Model\Blog\Blog;
use App\Model\Blog\BlogCategory;
use App\Model\Sitemap;
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

        $res = app(Blog::class)->getPageList($page, $limit, [], ['post_id', 'title', 'keywords', 'is_active', 'category_id', 'show_in_home', 'created_at', 'updated_at']);
        if (!empty($res['list'])) {
            foreach ($res['list'] as $re) {
                if (isset($re->category_id) && !empty($re->category_id) && $re->category_id != 0) {
                    $category = BlogCategory::findOrFail($re->category_id);
                    $re->category_id = $category->title;
                }
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

    public function addPost(Request $request, Base64ImageHandler $uploader)
    {
        $data = $request->toArray();
        $content = isset($data['content']) ? $data['content'] : '';
        $short_content = isset($data['short_content']) ? $data['short_content'] : '';
        $is_active = $data['is_active'] == 1 ? $data['is_active'] : 0;
        $title = isset($data['title']) ? $data['title'] : '';
        if (empty($title)) return redirect::back()->withErrors('添加失败，缺少标题');

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $featured_img = $request->featured_img[0])) {
            $data['featured_img'] = $uploader->base64_image_content($featured_img, 'product') ?? '';
        }

        $params = [
            'title' => $title,
            'meta_title' => $title,
            'meta_description' => make_excerpt($content) ?? '',
            'content' => $content,
            'short_content' => $short_content,
            'publish_time' => date('Y-m-d H:i:s'),
            'is_active' => $is_active,
            'show_in_home' => $data['show_in_home'],
            'featured_img' => $data['featured_img'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (isset($data['category_id']) && $category_id = $data['category_id']) {
            $params['category_id'] = $category_id;
        }
        if (isset($data['keywords']) && $keywords = $data['keywords']) {
            $params['keywords'] = $keywords;
        }
        if (isset($data['relate_id']) && $relate = $data['relate_id']) {
            $relate_text = '';
            foreach ($relate as $rela) {
                $relate_text = ($relate_text == '') ? $rela : $relate_text . ',' . $rela;
            }
            $params['relate_id'] = $relate_text;
        }

        try {
            app(Blog::class)->addPost($params);
            $new = Blog::select(['post_id'])->where('title', $title)->first();
            //添加siteMap
            $siteMap = [
                'type' => 10,
                'methed' => 1,
                'name' => '文章详情',
                'url' => '/news/' . str_replace(' ', '-', $title),
                'origin' => '/loctek/blog/' . $new->post_id
            ];
            Sitemap::create($siteMap);
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

    public function update(BlogRequest $request, Blog $blog, Base64ImageHandler $uploader)
    {
        $blog->fill($request->all());

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $featured_img = $request->featured_img[0])) {
            $blog->featured_img = $uploader->base64_image_content($featured_img, 'product');
        }

        if ($request->relate_id) {
            $blog->relate_id =  implode(',', $request->relate_id);
        }

        $blog->save();

        return redirect()->route('admin.blog.article')->with(['success' => '更新成功']);
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

    public function RataleBlogList(Request $request)
    {
        if ($request->blog_id != 0) {
            $blogData = Blog::findOrFail($request->blog_id);
            $relates = [];
            if (isset($blogData->relate_id) && $blogData->relate_id != '') {
                $relates = explode(',', $blogData->relate_id);
            }
        }
        $Blogs = Blog::select(['post_id', 'title'])->where('is_active', 1)->orderBy('position', 'DESC')->get();
        foreach ($Blogs as $item) {
            $item->value = $item->post_id; //赋值给value，title已有，不用重新赋值
            if (isset($blogData) && !empty($blogData)) {
                if ($item->post_id == $request->blog_id) {
                    $item->disabled = true;
                }
                if (in_array($item->post_id, $relates)) {
                    $item->checked = 'checked';
                }
            }
            unset($item->post_id);
        }
        return json_encode($Blogs);
    }
}
