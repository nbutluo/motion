<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\SystemConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class SystemConfigController extends Controller
{

    public function index()
    {
        return view('admin.config.website_seo');
    }

    public function data(Request $request)
    {
        $website_seo = SystemConfig::paginate($request->get('limit',30));
        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $website_seo->total(),
            'data' => $website_seo->items()
        ];
        return Response::json($data);
    }

    public function create()
    {
        return view('admin.config.website_seo_create');
    }

    public function store(Request $request)
    {
        if ($request->aystem_name == '') {
            return Redirect::back()->withErrors('请选择配置类型');
        }
        try {
            $data = [];
//            $data['seo_default_keywords'] = $request->seo_default_keywords;
//            $data['seo_default_title'] = $request->seo_default_title;
//            $data['seo_default_description'] = $request->seo_default_description;
//            $data['seo_default_globle'] = $request->seo_default_globle;
            $data[$request->aystem_name] = $request->value;
            foreach ($data as $key => $value) {
                SystemConfig::create([
                    'identifier' => $key,
                    'value' => $value,
                ]);
            }
            return Redirect::to(URL::route('admin.website_seo'))->with(['success'=>'添加成功']);
        } catch (\Exception $exception) {
//            return Redirect::back()->withErrors($exception->getMessage());
            return Redirect::back()->withErrors('添加失败');
        }
    }

    public function edit($id)
    {
        $seo = SystemConfig::findOrFail($id);
        return view('admin.config.website_seo_edit',compact('seo'));
    }

    public function update(Request $request,$id)
    {
        $seo = SystemConfig::findOrFail($id);
        $data = $request->only(['value']);
        try {
            $seo->update($data);
            return Redirect::to(URL::route('admin.website_seo'))->with(['success' => '更新成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors('更新失败');
        }
    }

    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (!is_array($ids) || empty($ids)) {
            return Response::json(['code' => 1, 'msg' => '请选择删项']);
        }
        try{
            SystemConfig::destroy($ids);
            return Response::json(['code'=>0,'msg'=>'删除成功']);
        }catch (\Exception $exception){
            return Response::json(['code'=>1,'msg'=>'删除失败']);
        }
    }

//    public function getSeoInfo()
//    {
//        $data = app(SystemConfig::class)->getWebsiteSeo();
//        return response()->json($data);
//    }
//
//    public function updateSeoConfig(Request $request)
//    {
//        $data = [];
//        if ($keywords = $request->input('keywords')) {
//            $data['seo_default_keywords'] = $keywords;
//        }
//        if ($title = $request->input('title')) {
//            $data['seo_default_title'] = $title;
//        }
//        if ($description = $request->input('description')) {
//            $data['seo_default_description'] = $description;
//        }
//
//        $res = app(SystemConfig::class)->updateSeo($data);
//
//        if ($res) {
//            return response()->json(['msg' => 'success','data' => $res]);
//        } else {
//            return response()->json(['msg' => 'failure','data' => $res]);
//        }
//    }
}
