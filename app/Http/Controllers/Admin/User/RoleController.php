<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Model\Permission;
use App\Model\Role;
use App\Model\User\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class RoleController extends Controller
{
    /**
     * 角色列表
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.role.index');
    }

    /**
     * 角色列表接口数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $res = Role::paginate($request->get('limit',30));
        $data = [
            'code' => 0,
            'msg' => 'loading......',
            'count' => $res->total(),
            'data' => $res->items()
        ];
        return Response::json($data);
    }

    /**
     * 角色创建表单
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * 添加角色操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->only(['name','display_name']);
        try {
            Role::create($data);
            return Redirect::to(URL::route('admin.role'))->with(['success'=>'添加成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors('添加失败');
        }
    }

    /**角色编辑表单
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $role = Role::findOrfail($id);
        return view('admin.role.edit',compact('role'));
    }

    /**
     * 更新角色
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,$id)
    {
        $role = Role::findOrFail($id);
        $data = $request->only(['name','display_name']);
        try {
            $role->update($data);
            return Redirect::to(URL::route('admin.role'))->with(['success' => '更新成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors('更新失败');
        }
    }

    /**
     * 分配权限表单
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function permission(Request $request,$id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::with('allChilds')->where('parent_id',0)->get();
        foreach ($permissions as $p1){
            $p1->own = $role->hasPermissionTo($p1->id) ? 'checked' : false ;
            if ($p1->childs->isNotEmpty()){
                foreach ($p1->childs as $p2){
                    $p2->own = $role->hasPermissionTo($p2->id) ? 'checked' : false ;
                    if ($p2->childs->isNotEmpty()){
                        foreach ($p2->childs as $p3){
                            $p3->own = $role->hasPermissionTo($p3->id) ? 'checked' : false ;
                        }
                    }
                }
            }
        }
        return view('admin.role.permission',compact('role','permissions'));
    }

    /**
     * 分配权限
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignPermission(Request $request,$id)
    {
        $role = Role::findOrFail($id);
        $permissions = $request->get('permissions',[]);
        try{
            $role->syncPermissions($permissions);
            return Redirect::to(URL::route('admin.role'))->with(['success'=>'更新成功']);
        }catch (\Exception $exception){
            return Redirect::back()->withErrors('更新失败');
        }
    }

    /**
     * 删除角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (!is_array($ids) || empty($ids)) {
            return Response::json(['code' => 1, 'msg' => '请选择删项']);
        }
        try{
            Role::destroy($ids);
            return Response::json(['code'=>0,'msg'=>'删除成功']);
        }catch (\Exception $exception){
            return Response::json(['code'=>1,'msg'=>'删除失败']);
        }
    }

}
