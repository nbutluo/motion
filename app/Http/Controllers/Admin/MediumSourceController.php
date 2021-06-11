<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\MediumSource;
use App\Model\MediumSourceCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class MediumSourceController extends AdminController
{
    protected $mediumModel;

    public function __construct(MediumSource $mediumModel)
    {
        //parent::__construct();
        $this->mediumModel = $mediumModel;
    }

    /**
     * @function 基础分类模块
     * @return array
     */
    public function baseCategories()
    {
        return [
            (object)['id' => 1, 'name' => '图片'],
            (object)['id' => 2, 'name' => '视频'],
            (object)['id' => 3, 'name' => '宣传册'],
            (object)['id' => 4, 'name' => '安装信息'],
            (object)['id' => 5, 'name' => '资质认证']
        ];
    }

    public function index()
    {
        $categories = $this->baseCategories();
        $categoryData = $this->categoryData();
        return view('admin.medium.index', compact('categories','categoryData'));
    }

    public function getList(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);

        $where = [];
        if ($media_type = $request->input('media_type')) {
            $where['media_type'] = $media_type;
        }
        if ($category_id = $request->input('category_id')) {
            $where['category_id'] = $category_id;
        }
        if ($title = $request->input('title')) {
            $where['title'] = $title;
        }

        $res = $this->mediumModel->getPageList($page, $limit, $where);

        return response()->json([
            'code' => 0,
            'msg' => '获取成功',
            'count' => $res['total'],
            'data' => $res['list'],
        ]);
    }

    public function categoryData ()
    {
        $categoriesData = [];
        $allCategories = MediumSourceCategory::select(['id','name','parent_id','identity'])->get();
        foreach ($allCategories as $allCategory) {
            $categoriesData[$allCategory->id] = $allCategory->toArray();
        }
        $allCateData = [];
        foreach ($categoriesData as $cateData) {
            $data = [];
            if ($cateData['parent_id'] == 0) {
                $data['title'] = $cateData['name'];
                $data['id'] = $cateData['id'];
                foreach ($categoriesData as $key_first => $firstCategory) {
                    $firstData = [];
                    if ($firstCategory['parent_id'] == $cateData['id']) {
                        $firstData['title'] = $firstCategory['name'];
                        $firstData['id'] = $firstCategory['id'];
                        $secondData = [];
                        foreach ($categoriesData as $key_second => $secondCategory) {
                            $thirdData = [];
                            if ($secondCategory['parent_id'] == $firstCategory['id']) {
                                $thirdData['title'] = $secondCategory['name'];
                                $thirdData['id'] = $secondCategory['id'];
                                $secondData[] = $thirdData;
                            }
                        }
                        $firstData['children'] = $secondData;
                        $data['children'][] = $firstData;
                    }
                }
                $allCateData[] = $data;
            }
        }
        return $allCateData;
    }

    public function create()
    {
        $categories = $this->baseCategories();
        $categoryData = $this->categoryData();
        return view('admin.medium.create', compact('categories','categoryData'));
    }

    public function store(Request $request)
    {
        $params['title'] = (isset($request->title) && $request->title != '') ? $request->title : '';
        $params['description'] = (isset($request->description) && $request->description != '') ? $request->description : '';
        $params['media_type'] = (isset($request->media_type) && $request->media_type != '') ? $request->media_type : 0;
        $params['category_id'] = (isset($request->category_id) && $request->category_id != '') ? $request->category_id : 0;
        $params['media_url'] = (isset($request->media_url) && $request->media_url != '') ? $request->media_url : '';
        $params['media_links'] = (isset($request->media_links) && $request->media_links != '') ? $request->media_links : '';
        $params['position'] = (isset($request->position) && $request->position != '') ? $request->position : 0;
        $params['is_active'] = (isset($request->is_active) && $request->is_active != '') ? $request->is_active : 0;
        $params['created_at'] = date('Y-m-d H:i:s');

        try {
            $this->mediumModel->insertGetId($params);
            return redirect::to(URL::route('admin.medium.index'))->with(['success' => '添加成功']);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect::back()->withErrors('添加失败: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        try {
            $medium = $this->mediumModel->findOrFail($id);
            if (!$medium) throw new Exception('下载失败，信息不存在');
            if (isset($medium['media_url']) && $medium['media_url'] != '') {
                $files = public_path() . $medium['media_url'];
            } elseif(isset($medium['media_links']) && $medium['media_links'] != '') {
                $files = public_path() . $medium['media_links'];
            } else {
                $files = '';
            }
            $name = basename($files);

            return response()->download($files, $name, $headers = ['Content-Type' => 'application/zip;charset=utf-8']);
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            echo '<span>下载失败，信息不存在!</span>';
            echo '<script>function goBack(){window.history.back()}</script>';
            echo '<a class="layui-btn" onclick="goBack()" style="margin-left: 20px;display: inline-block;height: 38px;line-height: 38px;padding: 0 18px;border: 1px solid transparent;background-color: #009688;color: #fff;white-space: nowrap;text-align: center;font-size: 14px;border-radius: 2px;cursor: pointer;">返 回</a>';
            exit;
        }
    }

    public function edit($id)
    {
        $media = $this->mediumModel->findOrFail($id);

        //分类
        $categories = $this->baseCategories();
        $categoryData = $this->categoryData();

        return view('admin.medium.edit', compact('media', 'categories','categoryData'));
    }

    public function update($id, Request $request)
    {
        if (empty($id)) return redirect::back()->withErrors('参数错误，缺少ID');

        $params = [];
        if ($title = $request->input('title')) {
            $params['title'] = $title;
        }
        if ($description = $request->input('description')) {
            $params['description'] = $description;
        }
        if ($media_type = $request->input('media_type')) {
            $params['media_type'] = $media_type;
        }
        if ($category_id = $request->input('category_id')) {
            $params['category_id'] = $category_id;
        }
        if ($media_url = $request->input('media_url')) {
            $params['media_url'] = $media_url;
        }
        if ($media_links = $request->input('media_links')) {
            $params['media_links'] = $media_links;
        }
        if ($position = $request->input('position')) {
            $params['position'] = $position;
        }
        $params['is_active'] = $request->input('is_active', 1);

        try {
            $this->mediumModel->updateMedia($id, $params);
            return redirect::to(URL::route('admin.medium.index'))->with(['success' => '更新成功']);
        } catch (\Exception $exception) {
            return redirect::back()->withErrors('更新失败');
        }
    }

    public function video()
    {
        $categories = $this->baseCategories();

        return view('admin.medium.video.index', compact('categories'));
    }

    public function instruction()
    {
        $categories = $this->baseCategories();

        return view('admin.medium.instruction.index', compact('categories'));
    }

    public function brochure()
    {
        $categories = $this->baseCategories();

        return view('admin.medium.brochure.index', compact('categories'));
    }

    public function qcfile()
    {
        $categories = $this->baseCategories();

        return view('admin.medium.qcfile.index', compact('categories'));
    }


}
