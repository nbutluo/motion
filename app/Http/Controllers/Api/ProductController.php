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

            return $this->success('success', $data);
        } catch (Exception $e) {
            return $this->fail('error, failure.', 500);
        }
    }

    public function detail($id, Request $request)
    {
        $select = [
            'id', 'name', 'sku', 'description', 'short_description', 'url_key', 'position', 'image', 'image_label', 'small_image', 'small_image_label'
        ];

        $data = $this->productModel->getDetailForApi($id, $select);

        if (!empty($data)) {
            // option 选项配置
            $data['option_size'] = $this->optionModel->where('product_id', $data['id'])->where('type', 1)->where('is_active', 1)->orderBy('sort_order', 'desc')->get();
            $data['option_color'] = $this->optionModel->where('product_id', $data['id'])->where('type', 2)->where('is_active', 1)->orderBy('sort_order', 'desc')->get();
            $data['desk_img'] = $this->optionModel->where('product_id', $data['id'])->where('type', 3)->where('is_active', 1)->orderBy('sort_order', 'desc')->get();
        }

        return $this->success('success', $data);
    }
}
