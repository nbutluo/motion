<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Product\Category;
use App\Model\Product\Option;
use App\Model\Product\Product;
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
                if (isset($list->image) && $list->image != '') {
                    $imageData = [];
                    $images = explode(';',$list->image);
                    foreach ($images as $image) {
                        $imageData[] =HTTP_TEXT.$_SERVER["HTTP_HOST"].$image;
                    }
                    $list->image = $imageData;
                }
                if (isset($list->small_image) && $list->small_image != '') {
                    $smallImages = explode(';',$list->small_image);
                    $smallImageData = [];
                    foreach ($smallImages as $smallImage) {
                        $smallImageData[] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$smallImage;
                    }
                    $list->small_image = $smallImageData;
                }
            }

            return $this->success('success', $data);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 403);
        }
    }

    public function detail($id, Request $request)
    {
        try {
            $select = [
                'id', 'name', 'sku', 'description','parameters', 'short_description', 'url_key', 'position', 'image', 'image_label', 'small_image', 'small_image_label','relate_ids'
            ];

            $data = $this->productModel->getDetailForApi($id, $select);
            if (isset($data['image']) && $data['image'] !='') {
                $images = explode(';',$data['image']);
                $imageData = [];
                foreach ($images as $image) {
                    $imageData[] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$image;
                }
                $data['image'] = $imageData;
            }
            if (isset($data['small_image']) && $data['small_image'] !='') {
                $data['small_image'] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$data['small_image'];
            }
            if (!empty($data)) {
                // option 选项配置
                $option_size = $this->optionModel->where('product_id', $data['id'])->where('type', 2)->where('is_active', 1)->orderBy('sort_order', 'desc')->get();
//                foreach ($option_size as $o_s) {
//                    if ($o_s['image'] != '') {
//                        $o_s['image'] = $_SERVER["HTTP_HOST"].$o_s['image'];
//                    }
//                }
//                $data['option_size'] = $option_size;
                $option_color = $this->optionModel->where('product_id', $data['id'])->where('type', 1)->where('is_active', 1)->orderBy('sort_order', 'desc')->get();
                foreach ($option_color as $o_c) {
                    if (isset($o_c['image']) && $o_c['image'] != '') {
                        $o_c['image'] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$o_c['image'];
                    }
                    //将option size放入对应option color中
                    $sizeData = [];
                    foreach ($option_size as $o_s) {
                        if (isset($o_s['option_color']) && $o_s['option_color'] != '' && $o_s['option_color'] == $o_c['option_color']) {
                            if (isset($o_s['image']) && $o_s['image'] != '') {
                                $o_s['image'] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$o_s['image'];
                            }
                            $sizeData[] = $o_s;
                        }
                    }
                    $o_c['option_size'] = $sizeData;
                }
                $data['option_color'] = $option_color;
                $desk_img = $this->optionModel->where('product_id', $data['id'])->where('type', 3)->where('is_active', 1)->orderBy('sort_order', 'desc')->get();
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
                        if (isset($relateProduct->image) && $relateProduct->image != '') {
                            $relateImages = explode(';',$relateProduct->image);
                            foreach ($relateImages as &$relateImage) {
                                $relateImage = HTTP_TEXT.$_SERVER["HTTP_HOST"].$relateImage;
                            }
                            $relateProduct->image = $relateImages;
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
}
