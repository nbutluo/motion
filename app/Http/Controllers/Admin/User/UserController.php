<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Model\Permission;
use App\Model\Role;
use App\Model\User\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * 用户管理主页
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * 获取列表数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $users = AdminUser::withTrashed()->paginate($request->get('limit',30));
        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $users->total(),
            'data' => $users->items()
        ];
        return Response::json($data);
    }

    /**
     * 创建用户表单
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * 创建用户
     * @param UserCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserCreateRequest $request)
    {
        $data = $request->all();
        try {
            $user = AdminUser::withTrashed()->select(['id'])->where('username',$data['username'])->first();
            if (isset($user->id)) {
                throw new \Exception('user has exists!');
            }
            AdminUser::create([
                'username' => $data['username'],
                'nickname' => $data['nickname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => $data['password'],
                'api_token' => hash('sha256', Str::random(60)),
            ]);
            return Redirect::to(URL::route('admin.user'))->with(['success'=>'添加成功']);
        } catch (\Exception $exception) {
//            return Redirect::back()->withErrors('添加失败');
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }

//    public function edit($id)
//    {
//        $user = AdminUser::findorFail($id);
//        return view('admin.user.edit',compact('user'));
//    }
//
//    public function update(UserUpdateRequest $request)
//    {
//
//    }

    /**
     * 分配角色表单
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function role($id)
    {
        $user = AdminUser::findOrFail($id);
        $roles = Role::get();
        foreach ($roles as $role) {
            $role->own = $user->hasRole($role) ? true : false;
        }
        return view('admin.user.role',compact('roles','user'));
    }

    /**
     * 分配角色操作
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignRole(Request $request,$id)
    {
        $user = AdminUser::findOrFail($id);
        $roles = $request->get('roles',[]);
        try {
            $user->syncRoles($roles);
            $data = [];
            $rule_id = '';
            foreach ($request->roles as $role) {
                $rule_id = ($rule_id == '') ? $role : $rule_id.','.$role;
            }
            $data['rule_id'] = $rule_id;
            $user->update($data);
            return Redirect::to(URL::route('admin.user'))->with(['success'=>'更新成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors('更新失败');
        }
    }

    /**
     * 分配权限
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function permission($id)
    {
        $user = AdminUser::findOrFail($id);
        $permissions = Permission::with('allChilds')->where('parent_id',0)->get();
        foreach ($permissions as $p1) {
            $p1->own = $user->hasPermissionto($p1->id) ? 'checked' : '';
            if ($p1->childs->isNotEmpty()) {
                foreach ($p1->childs as $p2) {
                    $p2->own = $user->hasPermissionto($p2->id) ? 'checked' : '' ;
                    if ($p2->childs->isNotEmpty()) {
                        foreach ($p2->childs as $p3) {
                            $p3->own = $user->hasPermissionto($p3->id) ? 'checked' : '';
                        }
                    }
                }
            }
        }
        return view('admin.user.permission',compact('user','permissions'));
    }

    /**
     * 分配权限操作
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignpermission(Request $request,$id)
    {
        $user = AdminUser::findOrFail($id);
        $permissions = $request->get('permissions',[]);
        try{
            $user->syncPermissions($permissions);
            return Redirect::to(URL::route('admin.user'))->with(['success'=>'更新成功']);
        }catch (\Exception $exception){
            return Redirect::back()->withErrors('更新失败');
        }
    }

    /**
     * 删除用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (!is_array($ids) || empty($ids)) {
            return Response::json(['code' => 1, 'msg' => '请选择删项']);
        }
        try {
            $adminUser = AdminUser::whereIn('id',$ids)->get();
            $adminUser->each->delete();

            if ($adminUser->each->trashed()) {
                return Response::json(['code' => 0, 'msg' => '删除成功']);
            } else {
                return Response::json(['code' => 1, 'msg' => '删除失败2']);
            }
        } catch (\Exception $exception) {
            return Response::json(['code' => 1, 'msg' => '删除失败1']);
        }
    }
}
