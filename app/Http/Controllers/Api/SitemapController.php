<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Blog\Blog;
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
        $type1 = [
            '/aboutUs' => ['name'=> '关于我们','method' => 1,'origin' => '/loctek/about-us'],
            '/contactUs' => ['name'=> '联系我们','method' => 2,'origin' => '/loctek/contact-us'],
            '/editOrder' => ['name'=> '用户订单页面','method' => 2,'origin' => '/loctek/order/user'],
            '/product' => ['name'=> '产品列表页面','method' => 1,'origin' => '/loctek/product/list'],
            '/search' => ['name'=> '搜索页面','method' => 2,'origin' => '/loctek/search'],
            '/shopCart' => ['name'=> '用户购物车页面','method' => 1,'origin' => '/loctek/product/getCart'],
            '/user' => ['name'=> '用户资料页面','method' => 1,'origin' => '/loctek/user'],
        ];
        $type2 = [

            '/product/detail' => '/loctek/product/info/{产品id}',
            '/news' => '/loctek/blog/{博客id}',
            '/FAQ' => '/loctek/faq/info/{FAQ id}',
        ];

        try {
//            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//            Sitemap::truncate();
//            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            //生成固定sitemap
            foreach ($type1 as $ty1Key => $ty1Value) {
                Sitemap::firstOrCreate(['url' => $ty1Key],['name' => $ty1Value['name'],'method' => $ty1Value['method'],'origin' => $ty1Value['origin'],'type' => 1]);
            }

            //生成产品详情
            $products = Product::select(['id'])->where('is_active',1)->get();
            foreach ($products as $product) {
                Sitemap::firstOrCreate(['url' => '/product/detail/'.$product->id],['name' => '产品详情','method' => 1,'origin' => '/loctek/product/info/'.$product->id,'type' => 2]);
            }

            //生成新闻链接
            $news = Blog::select(['post_id'])->where('is_active',1)->get();
            foreach ($news as $new) {
                Sitemap::firstOrCreate(['url' => '/news/'.$new->post_id],['name' => '文章详情','method' => 1,'origin' => '/loctek/blog/'.$new->post_id,'type' => 2]);
            }

            //生成FAQ链接
            $faqs = Question::select(['id'])->where('is_active',1)->get();
            foreach ($faqs as $faq) {
                Sitemap::firstOrCreate(['url' => '/FAQ/'.$faq->id],['name' => 'FAQ详情','method' => 1,'origin' => '/loctek/faq/info/'.$faq->id,'type' => 2]);
            }

            //获取sitemap数据
            $sitemaps = Sitemap::select(['url','origin'])->get();
            foreach ($sitemaps as $mapData) {
                $mapData->url = HTTP_TEXT.$_SERVER["HTTP_HOST"].$mapData->url;
                $mapData->origin = HTTP_TEXT.$_SERVER["HTTP_HOST"].$mapData->origin;
            }
            return $this->success('更新成功', $sitemaps);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 404);
        }
    }
}
