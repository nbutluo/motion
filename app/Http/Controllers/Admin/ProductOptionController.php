<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Product\Category;
use App\Model\Product\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class ProductOptionController extends AdminController
{

    protected $optionModel;

    public function __construct(Option $optionModel)
    {
        //parent::__construct();
        $this->optionModel = $optionModel;
    }

    public function index()
    {
        return view('admin.product-option.index');
    }

    public function getList(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);

        $where = [];
//        if ($option_id = $request->input('option_id')) {
//            $where['option_id'] = $option_id;
//        }
        if ($product_id = $request->input('product_id')) {
            $where['product_id'] = $product_id;
        }
        if ($title = $request->input('title')) {
            $where['title'] = $title;
        }
        if ($type = $request->input('type')) {
            $where['type'] = $type;
        }

        $res = $this->optionModel->getPageList($page, $limit, $where);

        return response()->json([
            'code' => 0,
            'msg' => '获取成功',
            'count' => $res['total'],
            'data' => $res['list'],
        ]);
    }

    /**
     * @function 基础option类型
     * @return array
     */
    public function baseType()
    {
        return [
            (object)['id' => 1, 'name' => '桌板颜色'],
            (object)['id' => 2, 'name' => 'size尺寸'],
            (object)['id' => 3, 'name' => 'desk图片'],
        ];
    }

    public function create()
    {
        //分类
        $categories = $this->baseType();

        return view('admin.product-option.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $params = [
            'sku' => $request->input('sku'),
            'product_id' => $request->input('product_id', 0),
            'title' => $request->input('title', ''),
            'type' => (int)$request->input('type', 1),
            'description' => $request->input('description'),
            'is_active' => $request->input('is_active', 0),
//            'sort_order' => $request->input('sort_order', 0),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($image = $request->input('image')) {
            $params['image'] = $image;
        }

        if ($option_color = $request->input('option_color')) {
            $params['option_color'] = $option_color;
        }

        if ($option_size = $request->input('option_size')) {
            $params['option_size'] = $option_size;
        }

        if ($sort_order = $request->input('sort_order')) {
            $params['sort_order'] = $sort_order;
        } else {
            $params['sort_order'] = 0;
        }

        try {
            if ($params['type'] == 2 && (!isset($params['option_color']) || empty($params['option_color']))) {
                throw new \Exception('必须设置对应颜色');
            }
            $this->optionModel->insertGetId($params);
            return redirect::to(URL::route('admin.catalog.option'))->with(['success' => '添加成功']);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect::back()->withErrors('添加失败: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = $this->optionModel->findOrFail($id);
        //分类
        $categories = $this->baseType();

        return view('admin.product-option.edit', compact('product', 'categories'));
    }

    public function update($id, Request $request)
    {
        if (empty($id)) return redirect::back()->withErrors('参数错误，缺少ID');

        $option = Option::where('id',$id);

        $params = [
            'sku' => $request->input('sku'),
            'product_id' => $request->input('product_id'),
            'title' => $request->input('title'),
            'type' => (int)$request->input('type'),
            'description' => $request->input('description'),
            'is_active' => $request->input('is_active'),
            'sort_order' => $request->input('sort_order')
        ];

        $params['image'] = isset($request->image) ? $request->input('image') : '';
        $params['option_color'] = isset($request->option_color) ? $request->input('option_color') : '';
        $params['option_size'] = isset($request->option_size) ? $request->input('option_size') : '';

        try {
            if ($params['type'] == 2 && (!isset($params['option_color']) || empty($params['option_color']))) {
                throw new \Exception('必须设置对应颜色');
            }
            $option->update($params);
            return redirect::to(URL::route('admin.catalog.option'))->with(['success' => '添加成功']);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect::back()->withErrors('添加失败: ' . $e->getMessage());
        }
    }
}
