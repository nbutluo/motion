<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Companyprofile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class CompanyProfileController extends Controller
{
    public function index()
    {
        return view('admin.company-profile.index');
    }

    public function getList(Request $request)
    {
        $companyProfile = Companyprofile::paginate($request->get('limit',90));
        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $companyProfile->total(),
            'data' => $companyProfile->items()
        ];
        return Response::json($data);
    }

    public function create()
    {
        return view('admin.company-profile.create');
    }

    public function add(Request $request)
    {
        try {
            $data = $request->toArray();
            $params = [];
            $params['title'] = isset($data['title']) ? $data['title'] : '';
            $params['media_link'] = isset($data['media_link']) ? $data['media_link'] : '';
            $params['content'] = isset($data['content']) ? $data['content'] : '';
            $params['is_active'] = isset($data['is_active']) ? $data['is_active'] : 1;
            $params['position'] = isset($data['position']) ? $data['position'] : 0;
            Companyprofile::create($params);
            return Redirect::to(URL::route('admin.company.profile.index'))->with(['success'=>'添加成功']);
        } catch (\Exception $exception) {
            return redirect::back()->withErrors('添加失败: ' . $exception->getMessage());
        }
    }

    public function edit($id)
    {
        $profile = Companyprofile::findOrFail($id);
        return view('admin.company-profile.edit',compact('id','profile'));
    }

    public function update(Request $request) {
        try {
            $data = $request->toArray();
            $params = [];
            $params['title'] = $data['title'];
            $params['media_link'] = $data['media_link'];
            $params['content'] = $data['content'];
            $params['is_active'] = $data['is_active'];
            $params['position'] = $data['position'];
            $profile = Companyprofile::findOrFail($data['id']);
            $profile->update($params);
            return Redirect::to(URL::route('admin.company.profile.index'))->with(['success'=>'修改成功']);
        } catch (\Exception $exception) {
            return redirect::back()->withErrors('添加失败: ' . $exception->getMessage());
        }
    }

    public function destory(Request $request)
    {
        $ids = $request->get('ids');
        if (!is_array($ids) || empty($ids)) {
            return Response::json(['code' => 1, 'msg' => '请选择删项']);
        }
        try {
            Companyprofile::destroy($ids);
            return Response::json(['code'=>0,'msg'=>$ids]);
        } catch (\Exception $exception) {
            return Response::json(['code'=>1,'msg'=>$ids]);
        }
    }
}
