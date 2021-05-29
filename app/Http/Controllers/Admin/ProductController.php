<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;

use App\Model\Product\Category;
use App\Model\Product\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class ProductController extends AdminController
{

    protected $productModel;

    public function __construct(Product $productModel)
    {
        //parent::__construct();
        $this->productModel = $productModel;
    }

    public function index()
    {
        $categories = Category::where('is_active',1)->orderBy('position', 'asc')->get();
        return view('admin.product.index', compact('categories'));
    }

    public function getList(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);

        $where = [];
        if ($category_id = $request->input('category_id')) {
            $where['category_id'] = $category_id;
        }

        $res = $this->productModel->getPageList($page, $limit, $where);

        foreach ($res['list'] as $product) {
            if (isset($product['category_id']) && !empty($product['category_id'])) {
                $category = Category::findOrFail($product['category_id']);
                $product['category_id'] = $category->name;
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
        $category = Category::where('is_active',1)->orderBy('position', 'asc')->get();
        //分类重新排序
        $categories = [];
        foreach ($category as $cate) {
            if ($cate['level'] == 1) {
                $categories[] = $cate;
                foreach ($category as $cateItem) {
                    if ($cateItem['parent_id'] == $cate['id']) {
                        $categories[] = $cateItem;
                    }
                }
            }
        }

        return view('admin.product.create', compact('categories'));
    }

    public function addProduct(Request $request)
    {
        $images = '';
        if ($request->input('images') != '') {
            foreach ($request->input('images') as $image) {
                $images = ($images == '') ? $image : $images.';'.$image;
            }
        }
        $params = [
            'sku' => $request->input('sku', ''),
            'name' => $request->input('name', ''),
            'category_id' => (int)$request->input('category_id', 0),
            'short_description' => $request->input('short_description'),
            'description' => $request->input('description'),
            'is_active' => $request->input('is_active', 0),
//            'image' => $request->input('image'),//单图
            'image' => $images,//多图
            'image_label' => $request->input('image_label'),
            'position' => $request->input('position', 0),
            'small_image' => $request->input('small_image'),
            'small_image_label' => $request->input('small_image_label'),
        ];
        if (!isset($params['position'])) {
            $params['position'] = 0;
        }
        try {
            $this->productModel->insertGetId($params);
            return redirect::to(URL::route('admin.catalog.product'))->with(['success' => '添加成功']);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect::back()->withErrors('添加失败: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->findOrFail($id);
        if (isset($product->image) && !empty($product->image)) {
            $images = explode(';',$product->image);
            $product->image = $images;
        }
        //分类
        $category = Category::where('is_active',1)->orderBy('position', 'asc')->get();
        //分类重新排序
        $categories = [];
        foreach ($category as $cate) {
            if ($cate['level'] == 1) {
                $categories[] = $cate;
                foreach ($category as $cateItem) {
                    if ($cateItem['parent_id'] == $cate['id']) {
                        $categories[] = $cateItem;
                    }
                }
            }
        }
        return view('admin.product.edit', compact('product', 'categories'));
    }

    public function update($id, Request $request)
    {
        if (empty($id)) return redirect::back()->withErrors('参数错误，缺少ID');

        $images = '';
        if ($request->input('images') != '') {
            foreach ($request->input('images') as $image) {
                $images = ($images == '') ? $image : $images.';'.$image;
            }
        }
        $params = [];
        if ($sku = $request->input('sku')) {
            $params['sku'] = $sku;
        }
        if ($name = $request->input('name')) {
            $params['name'] = $name;
        }
        if ($category_id = $request->input('category_id')) {
            $params['category_id'] = $category_id;
        }
        $params['image'] = $images;
//        if ($image = $request->input('image')) {
//            $params['image'] = $image;
//        }
        if ($image_label = $request->input('image_label')) {
            $params['image_label'] = $image_label;
        }
        if ($short_description = $request->input('short_description')) {
            $params['short_description'] = $short_description;
        }
        if ($description = $request->input('description')) {
            $params['description'] = $description;
        }

        $params['is_active'] = $request->input('is_active', 1);

        try {
            $this->productModel->updateProduct($id, $params);
            return redirect::to(URL::route('admin.catalog.product'))->with(['success' => '更新成功']);
        } catch (\Exception $exception) {
            return redirect::back()->withErrors('更新失败');
        }
    }
}
