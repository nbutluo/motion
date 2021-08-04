<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Blog\BlogCategory;
use App\Model\Product\Category;
use Illuminate\Http\Request;
use App\Model\Product\Product;
use App\Model\Blog\Blog;

class SearchController extends ApiController
{
    public function search(Request $request)
    {
        try {
            $categories = Category::all();
            $categoryData = [];
            foreach ($categories as $category) {
                $categoryData[$category->id] = $category->toArray();
            }
            $blogCategories = BlogCategory::all();
            $blogCategoryData = [];
            foreach ($blogCategories as $blogCategory) {
                $blogCategoryData[$blogCategory->category_id] = $blogCategory->title;
            }
            if (isset($request->keywords) && $request->keywords != '') {
                $allBlogs = Blog::select(['post_id','title','featured_img','short_content','category_id'])
                    ->where('title',trim($request->keywords))
                    ->where('is_active',1)
                    ->orderBy('position','desc')
                    ->orWhere('title','like','%'.trim($request->keywords).'%')
                    ->get();
                $allProducts = Product::select(['id','name','sku','category_id','short_description','image'])
                    ->where('name',trim($request->keywords))
                    ->where('is_active',1)
                    ->orderBy('position','desc')
                    ->orWhere('name','like','%'.trim($request->keywords).'%')
                    ->get();
                if ($request->type == 2) {
                    $blogs = Blog::select(['post_id','title','featured_img','short_content','category_id'])
                        ->where('title',trim($request->keywords))
                        ->where('is_active',1)
                        ->orWhere('title','like','%'.trim($request->keywords).'%')
                        ->orderBy('position','desc')
                        ->offset(($request->page-1)*$request->page_size)
                        ->limit($request->page_size)->get();
                } elseif($request->type == 1) {
                    $products = Product::select(['id','name','sku','category_id','short_description','image'])
                        ->where('name',trim($request->keywords))
                        ->where('is_active',1)
                        ->orWhere('name','like','%'.trim($request->keywords).'%')
                        ->orderBy('position','desc')
                        ->offset(($request->page-1)*$request->page_size)
                        ->limit($request->page_size)->get();
                }
            } else {
                $allBlogs = Blog::select(['post_id','title','featured_img','short_content','category_id'])
                    ->where('is_active',1)->get();
                $allProducts = Product::select(['id','name','sku','category_id','short_description','image'])
                    ->where('is_active',1)->get();
                if ($request->type == 2) {
                    $blogs = Blog::select(['post_id','title','featured_img','short_content','category_id'])
                        ->where('is_active',1)
                        ->orderBy('position','desc')
                        ->offset(($request->page-1)*$request->page_size)
                        ->limit($request->page_size)->get();
                } elseif ($request->type == 1) {
                    $products = Product::select(['id','name','sku','category_id','short_description','image'])
                        ->where('is_active',1)
                        ->orderBy('position','desc')
                        ->offset(($request->page-1)*$request->page_size)
                        ->limit($request->page_size)->get();
                }
            }
            if (isset($allBlogs) && !empty($allBlogs)) {
                foreach ($allBlogs as $allBlog) {
                    if (isset($allBlog->category_id) && $allBlog->category_id != '') {
                        $allBlog->category_name = $blogCategoryData[$allBlog->category_id];
                    }
                    if (isset($allBlog->featured_img) && $allBlog->featured_img != '') {
                        $allBlog->featured_img = HTTP_TEXT.$_SERVER["HTTP_HOST"].$allBlog->featured_img;
                    }
                }
            }
            if (isset($allProducts) && !empty($allProducts)) {
                foreach ($allProducts as $allProduct) {
                    //添加分类信息
                    if ($allProduct->category_id != 0) {
                        $third_id = $allProduct->category_id;
                        if ($categoryData[$third_id]['parent_id'] == 0) {
                            $allProduct->secondCategory = $categoryData[$third_id]['name'];
                            $allProduct->thirdCategory = '';
                        } else {
                            $sedond_id = $categoryData[$third_id]['parent_id'];
                            $allProduct->secondCategory = $categoryData[$sedond_id]['name'];
                            $allProduct->thirdCategory = $categoryData[$third_id]['name'];
                        }
                    } else {
                        $allProduct->secondCategory = '';
                        $allProduct->thirdCategory = '';
                    }
                    if (isset($allProduct->image) && $allProduct->image != '') {
                        $allImages = explode(';',$allProduct->image);
                        $allImageArray = [];
                        foreach ($allImages as $allPic) {
                            $allImageArray[] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$allPic;
                        }
                        $allProduct->image = $allImageArray;
                    }
                }
            }
            if (isset($blogs) && !empty($blogs)) {
                foreach ($blogs as $blog) {
                    if (isset($blog->category_id) && $blog->category_id != '') {
                        $blog->category_name = $blogCategoryData[$blog->category_id];
                    }
                    if (isset($blog->featured_img) && $blog->featured_img != '') {
                        $blog->featured_img = HTTP_TEXT.$_SERVER["HTTP_HOST"].$blog->featured_img;
                    }
                }
            }
            if (isset($products) && !empty($products)) {
                foreach ($products as $product) {
                    //添加分类信息
                    if ($product->category_id != 0) {
                        $third_id = $product->category_id;
                        if ($categoryData[$third_id]['parent_id'] == 0) {
                            $product->secondCategory = $categoryData[$third_id]['name'];
                            $product->thirdCategory = '';
                        } else {
                            $sedond_id = $categoryData[$third_id]['parent_id'];
                            $product->secondCategory = $categoryData[$sedond_id]['name'];
                            $product->thirdCategory = $categoryData[$third_id]['name'];
                        }
                    } else {
                        $product->secondCategory = '';
                        $product->thirdCategory = '';
                    }
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
            $data['totle'] = count($allBlogs) + count($allProducts);
            $data['totle_pageNum'] = ceil($data['totle'] / $request->page_size);
            $data['product_totle'] = count($allProducts);
            $data['product_pageNum'] = ceil($data['product_totle'] / $request->page_size);
            $data['news_totle'] = count($allBlogs);
            $data['news_pageNum'] = ceil($data['news_totle'] / $request->page_size);
            if ($request->type == 0) {
                $allData = [];
                foreach ($allProducts as $key => $value) {
                    $allData[] = $value->toArray();
                }
                foreach ($allBlogs as $k =>$v) {
                    $allData[] = $v->toArray();
                }
                $giveData = [];
                for ($i = ($request->page-1)*$request->page_size ; $i < $request->page*$request->page_size; $i++) {
                    if (isset($allData[$i])) {
                        $giveData[] = $allData[$i];
                    } else {
                        break;
                    }
                }
                $data['list'] = $giveData;
            } elseif ($request->type == 1) {
                $data['list'] = $products;
            } elseif ($request->type == 2) {
                $data['list'] = $blogs;
            }
            return $this->success('success', $data);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 4003, []);
        }
    }
}
