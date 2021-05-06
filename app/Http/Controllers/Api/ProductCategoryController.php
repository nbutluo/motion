<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Product\Category;
use Exception;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{

    protected $categoryModel;

    public function __construct(Category $categoryModel)
    {
        //parent::__construct();
        $this->categoryModel = $categoryModel;
    }

    public function getList(Request $request)
    {
        try {
            $data = $this->categoryModel->getCategoryList();

            return $this->success('success', $data);
        } catch (Exception $e) {
            return $this->fail('error, failure.', 500);
        }
    }
}
