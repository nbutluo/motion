<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Business_solutions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class BusinessSolutionController extends AdminController
{
    public function index()
    {
        return view('admin.business-solution.index');
    }

    public function getList(Request $request)
    {
        $solutions = Business_solutions::paginate($request->get('limit',90));
        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $solutions->total(),
            'data' => $solutions->items()
        ];
        return Response::json($data);
    }

    public function create()
    {
        return view('admin.business-solution.create');
    }

    public function add(Request $request)
    {
        try {
            $data = $request->toArray();
            $params = [];
            if ($category_type = $data['category_type']) {
                $params['category_type'] = $category_type;
            }
            if ($data['title'] != '') {
                $params['title'] = $data['title'];
            }
            if ($data['media_link'] != '') {
                $params['media_link'] = $data['media_link'];
            }
            if ($data['position'] != '') {
                $params['position'] = $data['position'];
            }
            if ($data['content'] != '') {
                $params['content'] = $data['content'];
            }
            $params['is_active'] = $data['is_active'];
//            var_dump($params);
            Business_solutions::create($params);
            return Redirect::to(URL::route('admin.solution.index'))->with(['success'=>'添加成功']);
        } catch (\Exception $exception) {
            return redirect::back()->withErrors('添加失败: ' . $exception->getMessage());
        }
    }

    public function edit($id)
    {
        $solution = Business_solutions::findOrFail($id);
        return view('admin.business-solution.edit',compact('solution','id'));
    }

    public function update(Request $request)
    {
        try {
            $data = $request->toArray();
            $params = [];
            $params['category_type'] = (isset($data['category_type']) && $data['category_type']) ? $data['category_type'] : 1;
            $params['title'] = (isset($data['title']) && $data['title']) ? $data['title'] : '';
            $params['media_link'] = (isset($data['media_link']) && $data['media_link']) ? $data['media_link'] : '';
            $params['is_active'] = (isset($data['is_active']) && $data['is_active']) ? $data['is_active'] : 1;
            $params['position'] = (isset($data['position']) && $data['position']) ? $data['position'] : 0;
            $params['content'] = (isset($data['content']) && $data['content']) ? $data['content'] : '';
            $solution = Business_solutions::findOrFail($data['id']);
            $solution->update($params);
            return Redirect::to(URL::route('admin.solution.index'))->with(['success'=>'添加成功']);
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
        try{
            Business_solutions::destroy($ids);
            return Response::json(['code'=>0,'msg'=>'删除成功']);
        }catch (\Exception $exception){
            return Response::json(['code'=>1,'msg'=>'删除失败']);
        }
    }
}
