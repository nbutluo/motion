<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Product\Option;
use App\Model\Product\Product;
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
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 10);

        try {

            $where = [];
            if ($category_id = $request->input('category_id')) {
                $where['category_id'] = $category_id;
            }

            $select = [
                'id', 'name', 'sku', 'description', 'short_description', 'url_key', 'position', 'image', 'image_label', 'small_image', 'small_image_label'
            ];

            $data = $this->productModel->getPageList($page, $pageSize, $where, $select);

            foreach ($data['list'] as $list) {
                if ($list->image != '') {
                    $list->image = $_SERVER["HTTP_HOST"].$list->image;
                }
                if ($list->small_image != '') {
                    $list->small_image = $_SERVER["HTTP_HOST"].$list->small_image;
                }
            }

            return $this->success('success', $data);
        } catch (Exception $e) {
            return $this->fail('error, failure.', 500);
        }
    }

    public function detail($id, Request $request)
    {
        try {
            $select = [
                'id', 'name', 'sku', 'description', 'short_description', 'url_key', 'position', 'image', 'image_label', 'small_image', 'small_image_label'
            ];

            $data = $this->productModel->getDetailForApi($id, $select);
            if ($data['image'] !='') {
                $data['image'] = $_SERVER["HTTP_HOST"].$data['image'];
            }
            if ($data['small_image'] !='') {
                $data['small_image'] = $_SERVER["HTTP_HOST"].$data['small_image'];
            }
            if (!empty($data)) {
                // option 选项配置
                $option_size = $this->optionModel->where('product_id', $data['id'])->where('type', 2)->where('is_active', 1)->orderBy('sort_order', 'desc')->get();
                foreach ($option_size as $o_s) {
                    if ($o_s['image'] != '') {
                        $o_s['image'] = $_SERVER["HTTP_HOST"].$o_s['image'];
                    }
                }
                $data['option_size'] = $option_size;
                $option_color = $this->optionModel->where('product_id', $data['id'])->where('type', 1)->where('is_active', 1)->orderBy('sort_order', 'desc')->get();
                foreach ($option_color as $o_c) {
                    if ($o_c['image'] !== '') {
                        $o_c['image'] = $_SERVER["HTTP_HOST"].$o_c['image'];
                    }
                }
                $data['option_color'] = $option_color;
                $desk_img = $this->optionModel->where('product_id', $data['id'])->where('type', 3)->where('is_active', 1)->orderBy('sort_order', 'desc')->get();
                foreach ($desk_img as $d_i) {
                    if ($d_i['image'] != '') {
                        $d_i['image'] = $_SERVER["HTTP_HOST"].$d_i['image'];
                    }
                }
                $data['desk_img'] = $desk_img;
            }
            return $this->success('success', $data);
        } catch (Exception $exception) {
            return $this->fail('error, failure.', 403);
        }



    }
}
