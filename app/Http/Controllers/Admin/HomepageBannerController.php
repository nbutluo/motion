<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\HomepageBanner;
use Illuminate\Http\Request;
use App\Handlers\Base64ImageHandler;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\HomepageBannerRequest;
use Illuminate\Support\Str;

class HomepageBannerController extends Controller
{
    public function index()
    {
        return view('admin.banner.homepage.index');
    }

    public function getList(Request $request)
    {
        $banners = HomepageBanner::orderBy('updated_at', 'desc')->paginate($request->get('limit', 30));

        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $banners->total(),
            'data' => $banners->items()
        ];
        return Response::json($data);
    }

    public function create(Request $request)
    {
        return view('admin.banner.homepage.create');
    }

    public function store(HomepageBannerRequest $request, HomepageBanner $banner, Base64ImageHandler $uploader)
    {
        $data = $banner->fill($request->all());

        // 上傳PC端图
        $media_url_pc =  $data['media_url_pc'][0];
        $data['media_url_pc'] = $uploader->base64_image_content($media_url_pc);

        // 上传手机端图
        $media_url_mobile = $data['media_url_mobile'][0];
        $data['media_url_mobile'] = $uploader->base64_image_content($media_url_mobile);

        $banner->save();

        return redirect()->route('admin.homepage_banner')->with('success', '添加成功');
    }

    public function edit(Request $request, HomepageBanner $banner)
    {
        return view('admin.banner.homepage.edit', compact('banner'));
    }

    public function update(HomepageBannerRequest $request, HomepageBanner $banner, Base64ImageHandler $uploader)
    {
        $data = $banner->fill($request->all());

        // 判断PC端图是否有修改过
        $media_url_pc =  $data['media_url_pc'][0];
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $media_url_pc, $result)) {
            $data['media_url_pc'] = $uploader->base64_image_content($media_url_pc);
        } else {
            $data['media_url_pc'] = $media_url_pc;
        }

        // 判断手机端图是否有修改过
        $media_url_mobile = $data['media_url_mobile'][0];
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $media_url_mobile, $result)) {
            $data['media_url_mobile'] = $uploader->base64_image_content($media_url_mobile);
        } else {
            $data['media_url_mobile'] = $media_url_mobile;
        }

        $banner->save();

        return redirect()->route('admin.homepage_banner')->with('success', '更新成功');
    }

    public function destroy(HomepageBanner $banner)
    {
        if ($banner->is_active) {
            return  json_encode([
                'code' => 0,
                'msg' => '当前banner为启用状态，无法删除',
            ], 320);
            exit();
        }

        $banner->delete();

        // 软删除
        if ($banner->trashed()) {
            return  json_encode([
                'code' => 1,
                'msg' => '删除成功',
            ], 320);
        }
    }
}
