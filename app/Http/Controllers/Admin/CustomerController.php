<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\User\AdminUser;
use App\Model\User\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin.customer.index');
    }

    public function getList(Request $request)
    {
        $users = Users::paginate($request->get('limit',90));
        foreach ($users as $user) {
            if ($user->salesman == 0) {
                $user->salesman = '未分配';
            } else {
                $salesman = AdminUser::findOrFail($user->salesman);
                $user->salesman = $salesman->nickname.'-'.$salesman->email;
            }
        }
        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $users->total(),
            'data' => $users->items()
        ];
        return Response::json($data);
    }

    public function create()
    {
        $adminUsers = AdminUser::select(['id','nickname'])->where('rule_id','like','%3%')->get();
        return view('admin.customer.create',compact('adminUsers'));
    }

    public function add(Request $request)
    {
        try {
            $params = [];
            $params['username'] = $request->user_name;
            $params['email'] = $request->user_name;
            $params['password'] = Hash::make($request->pass_word);
            $params['nickname'] = (isset($request->nickname)) ? $request->nickname : '';
            $params['sex'] = $request->sex;
            $params['phone'] = (isset($request->phone)) ? $request->phone : '';
            $params['company_url'] = (isset($request->company_url)) ? $request->company_url : '';
            $params['salesman'] = $request->salesman;
            $params['api_token'] = Hash::make(Str::random(60));
            Users::create($params);
            return Redirect::to(URL::route('admin.customer.index'))->with(['success'=>'添加成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }

    public function edit($id)
    {
        $adminUsers = AdminUser::select(['id','nickname'])->where('rule_id','like','%3%')->get();
        $user = Users::findOrFail($id);
        return view('admin.customer.edit',compact('id','adminUsers','user'));
    }

    public function update(Request $request)
    {
        try {
            $user = Users::findOrFail($request->id);
            $user->nickname = (isset($request->nickname)) ? $request->nickname : '';
            $user->sex = $request->sex;
            $user->phone = (isset($request->phone)) ? $request->phone : '';
            $user->company_url = (isset($request->company_url)) ? $request->company_url : '';
            $user->salesman = (isset($request->salesman)) ? $request->salesman : '';
            $user->save();
            return Redirect::to(URL::route('admin.customer.index'))->with(['success'=>'添加成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }
}
