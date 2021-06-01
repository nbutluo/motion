<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Model\Product\Product;
use App\Model\Blog\Blog;

class SearchController extends ApiController
{
    public function search(Request $request)
    {
        try {
            if (isset($request->keywords) && $request->keywords != '') {
                $blogs = Blog::select(['post_id','title','featured_img','short_content'])
                    ->where('title',trim($request->keywords))
                    ->where('is_active',1)
                    ->orWhere('title','like','%'.trim($request->keywords).'%')
                    ->get();
                $products = Product::select(['id','name','sku','short_description','image'])
                    ->where('name',trim($request->keywords))
                    ->where('is_active',1)
                    ->orWhere('name','like','%'.trim($request->keywords).'%')
                    ->get();
            } else {
                $blogs = Blog::where('is_active',1)->get();
                $products = Product::where('is_active',1)->get();
            }
            if (isset($blogs) && !empty($blogs)) {
                foreach ($blogs as $blog) {
                    if (isset($blog->featured_img) && $blog->featured_img != '') {
                        $blog->featured_img = HTTP_TEXT.$_SERVER["HTTP_HOST"].$blog->featured_img;
                    }
                }
            }
            if (isset($products) && !empty($products)) {
                foreach ($products as $product) {
                    if (isset($product->image) && $product->image != '') {
                        $images = explode(';',$product->image);
                        $imageArray = [];
                        foreach ($images as $pic) {
                            $imageArray[] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$pic;
                        }
                        $product->image = $imageArray;
                    }
                }
            }
            $data = [];
            $data['totle'] = count($blogs) + count($products);
            $data['products']['total'] = count($products);
            $data['products']['list'] = $products;
            $data['news']['total'] = count($blogs);
            $data['news']['list'] = $blogs;
            return $this->success('success', $data);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 4003, []);
        }
    }
}
