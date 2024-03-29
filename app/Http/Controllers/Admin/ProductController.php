<?php

namespace App\Http\Controllers\Admin;

use App\Handlers\Base64ImageHandler;
use App\Http\Controllers\AdminController;
use App\Http\Requests\ProductRequest;
use App\Model\Product\Category;
use App\Model\Product\Product;
use App\Model\Sitemap;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Handlers\VideoUploadHandler;
use Illuminate\Support\Str;

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
        $categories = Category::where('is_active', 1)->orderBy('position', 'asc')->get();
        return view('admin.product.index', compact('categories'));
    }

    public function RelateProductList(Request $request)
    {
        if ($request->product_id != 0) {
            $productData = Product::findOrFail($request->product_id);
            $relates = explode(',', $productData->relate_ids);
        }
        $products = Product::select(['id', 'name'])->where('is_active', 1)->orderBy('position', 'asc')->get();
        foreach ($products as $product) {
            $product->value = $product->id;
            $product->title = $product->name;
            if (isset($productData) && !empty($productData)) {
                if ($product->id == $request->product_id) {
                    $product->disabled = true;
                }
                if (in_array($product->id, $relates)) {
                    $product->checked = 'checked';
                }
            }

            unset($product->id);
            unset($product->name);
        }
        return json_encode($products);
    }

    public function SetProductList(Request $request, Product $product)
    {
        $set_product_ids = explode(',', $product->set_product_ids);

        // $set_product_list =  Product::whereIn('id', $set_product_ids)
        //     ->orderByRaw(\DB::raw("FIELD(id, $product->set_product_ids)"))
        //     ->get();

        $products = Product::select(['id', 'name'])->where('is_active', 1)->orderBy('position', 'asc')->get();
        foreach ($products as $product) {
            $product->value = $product->id;
            $product->title = $product->name;

            if ($product->id == $request->product_id) {
                $product->disabled = true;
            }
            if (in_array($product->id, $set_product_ids)) {
                $product->checked = 'checked';
            }
            unset($product->id);
            unset($product->name);
        }
        $products['checked'] = $set_product_ids;
        return json_encode($products);
    }

    public function getList(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);

        $where = [];
        if ($category_id = $request->input('category_id')) {
            $where['category_id'] = $category_id;
        }
        if ($sku = $request->input('sku')) {
            $where['sku'] = $sku;
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
        $category = Category::where('is_active', 1)->orderBy('position', 'asc')->get();
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

    public function addProduct(ProductRequest $request, Base64ImageHandler $uploader)
    {
        $data = $request->all();
        // dda($data);
        foreach ($data['image'] as $key => $value) {
            $res = $uploader->base64_image_content($value, 'product');
            $data['image'][$key] = $res;
        }
        $images = implode(';', $data['image']);

        $params = [
            'sku' => $request->input('sku', ''),
            'name' => $request->input('name', ''),
            'category_id' => (int)$request->input('category_id', 0),
            'short_description' => $request->input('short_description'),
            'description' => $request->input('description'),
            'description_mobile' => $request->description_mobile,
            'is_active' => $request->input('is_active', 0),
            //            'image' => $request->input('image'),//单图
            'image' => $images, //多图
            'image_label' => $request->input('image_label'),
            'position' => $request->input('position', 0),
            'small_image' => $request->input('small_image'),
            'small_image_label' => $request->input('small_image_label'),
            'video_url' => $request->input('video_url'),
            'meta_title' => $request->input('name', ''),
            'meta_description' => $request->input('short_description', ''),
        ];

        if ($video_poster = $request->input('video_poster')) {
            $params['video_poster'] = $uploader->base64_image_content($video_poster[0]);
        }

        $relate_ids = '';
        if (isset($request->relate_id) && !empty($request->relate_id)) {
            foreach ($request->relate_id as $relate) {
                $relate_ids = ($relate_ids == '') ? $relate : $relate_ids . ',' . $relate;
            }
            $params['relate_ids'] = $relate_ids;
        }
        if (!isset($params['position'])) {
            $params['position'] = 0;
        }
        try {
            $this->productModel->insertGetId($params);
            $new = Product::select(['id'])->where('sku', $request->sku)->first();
            //添加siteMap
            $categoryData = [];
            $categories = Category::select(['id', 'name', 'parent_id'])->get();
            foreach ($categories as $category) {
                $categoryData[$category->id]['name'] = $category->name;
                $categoryData[$category->id]['parent_id'] = $category->parent_id;
            }
            $parent = '';
            if ($categoryData[$request->category_id]['parent_id'] == 0) {
                $parent = '/' . $categoryData[$request->category_id]['name'];
            } else {
                $parent = '/' . $categoryData[$categoryData[$request->category_id]['parent_id']]['name'] . '/' . $categoryData[$request->category_id]['name'];
            }
            $parent = str_replace(' ', '-', $parent);
            $siteMap = [
                'type' => 10,
                'methed' => 1,
                'name' => '产品详情',
                'url' => $parent . '/' . $request->sku,
                'origin' => '/loctek/product/info/' . $new->id
            ];
            Sitemap::create($siteMap);
            return redirect::to(URL::route('admin.catalog.product'))->with(['success' => '添加成功']);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect::back()->withErrors('添加失败: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->findOrFail($id);
        // if (isset($product->image) && !empty($product->image)) {
        //     $images = explode(';', $product->image);
        //     $product->image = $images;
        // }
        //分类
        $category = Category::where('is_active', 1)->orderBy('position', 'asc')->get();
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

    public function update($id, ProductRequest $request, Base64ImageHandler $uploader, VideoUploadHandler $videoHandler)
    {
        $params = [];
        $data = $request->all();
        // dd($data);

        // 七牛云存储视频
        $file = $request->video_url;
        if ($file && !Str::startsWith($file, 'http')) {
            $params['video_url'] = $videoHandler->video_upload($file);
        } else {
            // 删除视频
            $params['video_url'] = $request->video_url ?: null;
        }

        if (empty($id)) return redirect::back()->withErrors('参数错误，缺少ID');
        // 图片上传
        foreach ($data['image'] as $key => $value) {
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $value)) {
                $res = $uploader->base64_image_content($value, 'product');
                $data['image'][$key] = $res;
            }
        }

        $relate_ids = '';
        if (isset($request->relate_id) && !empty($request->relate_id)) {
            foreach ($request->relate_id as $relate) {
                $relate_ids = ($relate_ids == '') ? $relate : $relate_ids . ',' . $relate;
            }
            $params['relate_ids'] = $relate_ids;
        }

        $set_product_ids = '';
        if (isset($request->set_product_ids) && !empty($request->set_product_ids)) {
            foreach ($request->set_product_ids as $set) {
                $set_product_ids = ($set_product_ids == '') ? $set : $set_product_ids . ',' . $set;
            }
            $params['set_product_ids'] = $set_product_ids;
        }

        if ($sku = $request->input('sku')) {
            $params['sku'] = $sku;
        }
        if ($name = $request->input('name')) {
            $params['name'] = $name;
        }
        if ($category_id = $request->input('category_id')) {
            $params['category_id'] = $category_id;
        }

        $params['image'] = implode(';', $data['image']);

        if ($image_label = $request->input('image_label')) {
            $params['image_label'] = $image_label;
        }
        if ($short_description = $request->input('short_description')) {
            $params['short_description'] = $short_description;
        }
        if ($description = $request->input('description')) {
            $params['description'] = $description;
        }
        if ($description_mobile = $request->input('description_mobile')) {
            $params['description_mobile'] = $description_mobile;
        }
        if ($parameters = $request->input('parameters')) {
            $params['parameters'] = $parameters;
        }

        // 如果取消商品作为新品，相应的新品顺序设置为 null
        if ($request->is_new_arrival == 0) {
            $params['new_arrival_order'] = null;
        }

        // 上传视频封面
        if ($video_poster = $request->input('video_poster')[0]) {
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $video_poster)) {
                $params['video_poster'] = $uploader->base64_image_content($video_poster);
            }
        } else {
            $params['video_poster'] = null;
        }

        $params['parameters_mobile'] =  $request->input('parameters_mobile');

        $params['is_active'] = $request->input('is_active', 1);

        $params['is_new_arrival'] = $request->input('is_new_arrival');
        $params['meta_description'] = $request->input('meta_description');
        $params['meta_title'] = $request->input('meta_title');
        $params['meta_keywords'] = $request->input('meta_keywords');

        try {
            $res =  $this->productModel->updateProduct($id, $params);
            return redirect::to(URL::route('admin.catalog.product'))->with(['success' => '更新成功']);
        } catch (\Exception $exception) {
            return redirect::back()->withErrors('更新失败');
        }
    }

    public function destroy(Product $product)
    {
        if ($product->is_active) {
            return  json_encode([
                'code' => 0,
                'msg' => '当前商品为启用状态，无法删除',
            ], 320);
            exit();
        }

        $product->delete();

        if ($product->trashed()) {
            return  json_encode([
                'code' => 1,
                'msg' => '删除成功',
            ], 320);
        }
    }

    public function video_upload(Request $request, VideoUploadHandler $videoHandler)
    {
        if ($request->hasFile('video_url')) {
            $path = $videoHandler->video_upload($request->video_url);
            return $path;
        }
    }
}
