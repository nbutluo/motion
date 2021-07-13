<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Blog\Blog;
use App\Model\Blog\BlogCategory;
use App\Model\Product\Category;
use App\Model\Product\Product;
use App\Model\Question;
use App\Model\Sitemap;
use App\Model\User\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SitemapController extends ApiController
{
    public function sitemap()
    {
        try {
            $this->createSiteMap();
            //获取sitemap数据
            $sitemaps = Sitemap::select(['type','url','origin'])->get();
//            foreach ($sitemaps as $mapData) {
//                $mapData->url = HTTP_TEXT.$_SERVER["HTTP_HOST"].$mapData->url;
//                $mapData->origin = HTTP_TEXT.$_SERVER["HTTP_HOST"].$mapData->origin;
//            }
            return $this->success('获取成功', $sitemaps);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 404);
        }
    }

    public function createSiteMap()
    {
        $siteMap = Sitemap::select(['id'])->get();

        if (!isset($siteMap[0])) {
            $type1 = [
                '/aboutUs' => ['name'=> '关于我们','method' => 1,'origin' => '/loctek/about-us','type' => 1],
                '/contactUs' => ['name'=> '联系我们','method' => 2,'origin' => '/loctek/contact-us','type' => 2],
                '/editOrder' => ['name'=> '用户订单页面','method' => 2,'origin' => '/loctek/order/user','type' => 3],
//                '/product' => ['name'=> '产品列表页面','method' => 1,'origin' => '/loctek/product/list','type' => 4],
                '/search' => ['name'=> '搜索页面','method' => 2,'origin' => '/loctek/search','type' => 4],
                '/shopCart' => ['name'=> '用户购物车页面','method' => 1,'origin' => '/loctek/product/getCart','type' => 5],
                '/user' => ['name'=> '用户资料页面','method' => 1,'origin' => '/loctek/user','type' => 6],
            ];
            $type2 = [

                '/product/detail' => '/loctek/product/info/{产品id}',
                '/news' => '/loctek/blog/{博客id}',
                '/FAQ' => '/loctek/faq/info/{FAQ id}',
            ];

            try {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                Sitemap::truncate();
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                //生成固定sitemap
                foreach ($type1 as $ty1Key => $ty1Value) {
                    Sitemap::firstOrCreate(['url' => $ty1Key],['name' => $ty1Value['name'],'method' => $ty1Value['method'],'origin' => $ty1Value['origin'],'type' => $ty1Value['type']]);
                }

                //生成产品分类链接
                $procate = [];
                $productCategories = Category::select(['id','name','parent_id'])->get();
                foreach ($productCategories as $productCategory) {
                    $procate[$productCategory->id]['parent_id'] = $productCategory->parent_id;
                    $procate[$productCategory->id]['name'] = $productCategory->name;
                }
                //产品分类map
                foreach ($procate as $key_category => $value_catgory) {
                    if ($value_catgory['parent_id'] == 0) {
                        $value_catgory['name'] = str_replace(' ','-',$value_catgory['name']);
                        Sitemap::firstOrCreate(['url' => '/'.$value_catgory['name']],['name' => '产品分类链接','method' => 1,'origin' => '/loctek/product/list','type' => 7]);
                        foreach ($procate as $key_cate => $value_cate) {
                            if ($value_cate['parent_id'] == $key_category) {
                                $value_cate['name'] = str_replace(' ','-',$value_cate['name']);
                                Sitemap::firstOrCreate(['url' => '/'.$value_catgory['name'].'/'.$value_cate['name']],['name' => '产品分类链接','method' => 1,'origin' => '/loctek/product/list','type' => 7]);
                            }
                        }
                    }
                }
                //生成产品详情链接
                $products = Product::select(['id','sku','category_id'])->get();
                foreach ($products as $product) {
                    if ($procate[$product->category_id]['parent_id'] == 0) {
                        $category_dir = $procate[$product->category_id]['name'];
                    } else {
                        $category_dir = $procate[$procate[$product->category_id]['parent_id']]['name'].'/'.$procate[$product->category_id]['name'];
                    }
                    $category_dir = str_replace(' ','-',$category_dir);
                    $product->sku = str_replace(' ','-',$product->sku);
                    Sitemap::firstOrCreate(['url' => '/'.$category_dir.'/'.$product->sku],['name' => '产品详情','method' => 1,'origin' => '/loctek/product/info/'.$product->id,'type' => 8]);
                }

                //生成新闻分类链接
                $news_category = [];
                $newsCategory = BlogCategory::select(['category_id','title'])->get();
                foreach ($newsCategory as $newsCate) {
                    $news_category[$newsCate->category_id] = $newsCate->title;
                    $newsCate->title = str_replace(' ','-',$newsCate->title);
                    Sitemap::firstOrCreate(['url' => '/news/'.$newsCate->title],['name' => 'blog分类','method' => 1,'origin' => '/loctek/category/blog-list','type' => 9]);
                }
                //生成新闻链接
                $news = Blog::select(['post_id','title','category_id'])->get();
                foreach ($news as $new) {
                    $news_category[$new->category_id] = str_replace(' ','-',$news_category[$new->category_id]);
                    $new->title = str_replace(' ','-',$new->title);
                    Sitemap::firstOrCreate(['url' => '/news/'.$news_category[$new->category_id].'/'.$new->title],['name' => '文章详情','method' => 1,'origin' => '/loctek/blogDetail/'.$new->title,'type' => 10]);
                }

                //生成FAQ链接
                $faqs = Question::select(['id','title'])->get();
                foreach ($faqs as $faq) {
                    $faq->title = str_replace(' ','-',$faq->title);
                    Sitemap::firstOrCreate(['url' => '/FAQ/'.$faq->title],['name' => 'FAQ详情','method' => 1,'origin' => '/loctek/faq/info/'.$faq->id,'type' => 11]);
                }
            } catch (\Exception $exception) {
                return $this->fail($exception->getMessage(), 404);
            }
        }
        return true;
    }
}
