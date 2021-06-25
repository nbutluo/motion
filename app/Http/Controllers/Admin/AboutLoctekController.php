<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AboutLoctek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class AboutLoctekController extends Controller
{
    public function index()
    {
        return view('admin.about-loctek.index');
    }

    public function getList(Request $request)
    {
        $AboutLocteks = AboutLoctek::paginate($request->get('limit',90));
        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $AboutLocteks->total(),
            'data' => $AboutLocteks->items()
        ];
        return Response::json($data);
    }

    public function create()
    {
        return view('admin.about-loctek.create');
    }

    public function add(Request $request)
    {
        $data = $request->all();
        if ($data['type'] == 1) {
            $about = AboutLoctek::select(['id'])->where('type',1)->first();
            if (isset($about->id) && $about->id) {
                return redirect::back()->withErrors('已有页面标题信息' );
            }
        }

        try {
            $params = [];
            $params['type'] = $data['type'];
            $params['title'] = (isset($data['title']) && $data['title'] != '') ? $data['title'] : '';
            $params['media_link'] = (isset($data['media_link']) && $data['media_link'] != '') ? $data['media_link'] : '';
            $params['media_type'] = $data['media_type'];
            $params['media_lable'] = (isset($data['media_lable']) && $data['media_lable'] != '') ? $data['media_lable'] : '';
            $params['content'] = (isset($data['content']) && $data['content'] != '') ? $data['content'] : '';
            $params['is_active'] = $data['is_active'];
            $params['position'] = (isset($data['position']) && $data['position'] != '') ? $data['position'] : 0;
            AboutLoctek::create($params);
            return Redirect::to(URL::route('admin.about.loctek.index'))->with(['success'=>'添加成功']);
        } catch (\Exception $exception) {
            return redirect::back()->withErrors('添加失败: ' . $exception->getMessage());
        }
    }

    public function edit($id)
    {
        $loctek = AboutLoctek::findOrFail($id);
        return view('admin.about-loctek.edit',compact('id','loctek'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $params = [];
        $params['type'] = $data['type'];
        $params['title'] = (isset($data['title']) && $data['title'] != '') ? $data['title'] : '';
        $params['media_link'] = (isset($data['media_link']) && $data['media_link'] != '') ? $data['media_link'] : '';
        $params['media_type'] = $data['media_type'];
        $params['media_lable'] = (isset($data['media_lable']) && $data['media_lable'] != '') ? $data['media_lable'] : '';
        $params['content'] = (isset($data['content']) && $data['content'] != '') ? $data['content'] : '';
        $params['is_active'] = $data['is_active'];
        $params['position'] = (isset($data['position']) && $data['position'] != '') ? $data['position'] : 0;
        try {
            $loctek = AboutLoctek::findOrFail($data['id']);
            $loctek->update($params);
            return Redirect::to(URL::route('admin.about.loctek.index'))->with(['success' => '更新成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }

    public function destory(Request $request)
    {
        try {
            AboutLoctek::destroy($request->id);
            return Response::json(['code'=>0,'msg'=>'删除成功']);
        } catch (\Exception $exception) {
            return Response::json(['code'=>1,'msg'=>$exception->getMessage()]);
        }
    }
}
