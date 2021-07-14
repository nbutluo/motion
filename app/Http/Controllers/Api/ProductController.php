<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Product\Category;
use App\Model\Product\Option;
use App\Model\Product\Product;
use App\Model\Sitemap;
use App\Model\User\Users;
use Exception;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    protected $productModel;
    protected $optionModel;

    public function __construct(Product $productModel, Option $optionModel)
    {
        //parent::__construct();
        $this->productModel = $productModel;
        $this->optionModel = $optionModel;
    }

    public function index(Request $request)
    {
        echo 111;
    }

    public function getList(Request $request)
    {
        $page = (isset($request->page) && $request->page != '') ? $request->page : 1;
        $pageSize = (isset($request->page_size) && $request->page_size != '') ? $request->page_size : 10;
        try {

            $where = [];
            if (isset($request->category_name) && $request->category_name != '') {
                $categoryData = Category::where('name',$request->category_name)->first();
                if ($categoryData) {
                    if ($categoryData->parent_id == 0) {
                        $categorys = Category::where('parent_id',$categoryData->id)->where('is_active',1)->get();
                        $cateArray = [];
                        foreach ($categorys as $cate) {
                            $cateArray[] = $cate->id;
                        }
                        $where['category_id'] = $cateArray;
                    } else {
                        $where['category_id'] = $categoryData->id;
                    }
                } else {
                    throw new Exception('there is no "'.$request->category_name.'"');
                }
            }
            $where['is_active'] = 1;
            $select = [
                'id', 'name', 'sku', 'description', 'short_description', 'url_key', 'position', 'image', 'image_label', 'small_image', 'small_image_label'
            ];

            $data = $this->productModel->getPageList($page, $pageSize, $where, $select);

            foreach ($data['list'] as $list) {
                $url_key = Sitemap::select(['url'])->where('origin','/loctek/product/info/'.$list->id)->first();
                $list->url_key = $url_key->url;
                if (isset($list->image) && $list->image != '') {
                    $imageData = [];
                    $images = explode(';',$list->image);
                    $list->image = [];
                    foreach ($images as $image) {
                        $imageData[] =HTTP_TEXT.$_SERVER["HTTP_HOST"].$image;
                    }
                    $list->image = $imageData;
                } else {
                    $list->image = [];
                }
                if (isset($list->small_image) && $list->small_image != '') {
                    $smallImages = explode(';',$list->small_image);
                    $list->small_image = [];
                    $smallImageData = [];
                    foreach ($smallImages as $smallImage) {
                        $smallImageData[] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$smallImage;
                    }
                    $list->small_image = $smallImageData;
                } else {
                    $list->small_image = [];
                }
            }

            return $this->success('success', $data);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 403);
        }
    }

    public function detail($id, Request $request)
    {
        $categories = Category::select(['id','name','parent_id'])->get();
        $allCateData = [];
        foreach ($categories as $category) {
            $allCateData[$category->id]['name'] = $category->name;
            $allCateData[$category->id]['parent_id'] = $category->parent_id;
        }
        try {
            $select = [
                'id', 'name', 'sku', 'description', 'description_mobile','parameters', 'short_description', 'url_key', 'position', 'image', 'image_label', 'small_image', 'small_image_label','relate_ids','category_id'
            ];

            $data = $this->productModel->getDetailForApi($id, $select);
            if ($allCateData[$data['category_id']]['parent_id'] == 0) {
                $data['secondCategory'] = $allCateData[$data['category_id']]['name'];
                $data['thirdCategory'] = '';
            } else {
                $data['secondCategory'] = $allCateData[$allCateData[$data['category_id']]['parent_id']]['name'];
                $data['thirdCategory'] = $allCateData[$data['category_id']]['name'];
            }
            $data['description'] = str_replace('src="/uploads','src="'.HTTP_TEXT.$_SERVER["HTTP_HOST"].'/uploads',$data['description']);
            $data['description_mobile'] = str_replace('src="/uploads','src="'.HTTP_TEXT.$_SERVER["HTTP_HOST"].'/uploads',$data['description_mobile']);
            $data['parameters'] = str_replace('src="/uploads','src="'.HTTP_TEXT.$_SERVER["HTTP_HOST"].'/uploads',$data['parameters']);
            if (isset($data['image']) && $data['image'] !='') {
                $images = explode(';',$data['image']);
                $imageData = [];
                $data['image'] = [];
                foreach ($images as $image) {
                    $imageData[] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$image;
                }
                $data['image'] = $imageData;
            } else {
                $data['image'] = [];
            }
            if (isset($data['small_image']) && $data['small_image'] !='') {
                $data['small_image'] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$data['small_image'];
            }
            if (!empty($data)) {
                // option 选项配置
                $option_size = $this->optionModel->select(['id','sku','title','option_size'])->where('product_id', $data['id'])->where('type', 2)->where('is_active', 1)->orderBy('sort_order', 'desc')->get();
//                foreach ($option_size as $o_s) {
//                    if ($o_s['image'] != '') {
//                        $o_s['image'] = $_SERVER["HTTP_HOST"].$o_s['image'];
//                    }
//                }
                $data['option_size'] = $option_size;
                $option_color = $this->optionModel->select(['id','sku','title','option_color'])->where('product_id', $data['id'])->where('type', 1)->where('is_active', 1)->orderBy('sort_order', 'desc')->get();
                foreach ($option_color as $o_c) {
                    if (isset($o_c['image']) && $o_c['image'] != '') {
                        $o_c['image'] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$o_c['image'];
                    }
//                    //将option size放入对应option color中
//                    $sizeData = [];
//                    foreach ($option_size as $o_s) {
//                        if (isset($o_s['option_color']) && $o_s['option_color'] != '' && $o_s['option_color'] == $o_c['option_color']) {
//                            if (isset($o_s['image']) && $o_s['image'] != '') {
//                                $o_s['image'] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$o_s['image'];
//                            }
//                            $sizeData[] = $o_s;
//                        }
//                    }
//                    $o_c['option_size'] = $sizeData;
                }
                $data['option_color'] = $option_color;
                $desk_img = $this->optionModel->select(['id','sku','title','image','image_alt'])->where('product_id', $data['id'])->where('type', 3)->where('is_active', 1)->orderBy('sort_order', 'desc')->get();
                foreach ($desk_img as $d_i) {
                    if (isset($d_i['image']) && $d_i['image'] != '') {
                        $d_i['image'] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$d_i['image'];
                    }
                }
                $data['desk_img'] = $desk_img;
                //获取关联产品
                if ($data['relate_ids'] !='') {
                    $relates = explode(',',$data['relate_ids']);
                    $relateData = [];
                    foreach ($relates as $relate) {
                        $relateProduct = Product::select(['id','name','image'])->findOrFail($relate);
                        $relate_urlKey = Sitemap::select(['url'])->where('origin','/loctek/product/info/'.$relate)->first();
                        $relateProduct->url_key = $relate_urlKey->url;
                        if (isset($relateProduct->image) && $relateProduct->image != '') {
                            $relateImages = explode(';',$relateProduct->image);
                            $relateProduct->image = [];
                            foreach ($relateImages as &$relateImage) {
                                $relateImage = HTTP_TEXT.$_SERVER["HTTP_HOST"].$relateImage;
                            }
                            $relateProduct->image = $relateImages;
                        } else {
                            $relateProduct->image = [];
                        }
                        $relateData[] = $relateProduct;
                    }
                    $data['relate'] = $relateData;
                }
            }
            return $this->success('success', $data);
        } catch (Exception $exception) {
            return $this->fail($exception->getMessage(), 403);
        }



    }

    public function newProduct()
    {
        try {
            $categories = Category::all();
            $allCateData = [];
            foreach ($categories as $category) {
                $allCateData[$category->id] = $category->toArray();
            }
            $relates = Product::select(['id','name','category_id','image'])->where('is_active',1)->orderBy('created_at','DESC')->limit(4)->get();
            foreach ($relates as $relate) {
                $url_key = Sitemap::select(['url'])->where('origin','/loctek/product/info/'.$relate->id)->first();
                $relate->url_key = $url_key->url;
                //添加分类信息
                if ($relate->category_id != 0) {
                    $third_id = $relate->category_id;
                    if ($allCateData[$third_id]['parent_id'] == 0) {
                        $relate->secondCategory = $allCateData[$third_id]['name'];
                        $relate->thirdCategory = '';
                    } else {
                        $sedond_id = $allCateData[$third_id]['parent_id'];
                        $relate->secondCategory = $allCateData[$sedond_id]['name'];
                        $relate->thirdCategory = $allCateData[$third_id]['name'];
                    }
                } else {
                    $relate->secondCategory = '';
                    $relate->thirdCategory = '';
                }
                if (isset($relate->image) && $relate->image != '') {
                    $imageData = [];
                    $images = explode(';',$relate->image);
                    $relate->image = [];
                    foreach ($images as $image) {
                        $imageData[] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$image;
                    }
                    $relate->image = $imageData;
                } else {
                    $relate->image = [];
                }
            }
            return $this->success('success', $relates);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 4003, []);
        }
    }
}
