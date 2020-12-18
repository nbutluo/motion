<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.logins.showLoginForm');
    }

    public function login(Request $request)
    {
        $res = Admin::where([
            'name' => $request->name,
            'password' => $request->password
        ])->get();

        //如果有就代表账号密码正确,写入session
        if ($res->count()) {
            $request->session()->put('user', $request->name);
            session()->flash('success', '欢迎回来！');
            return redirect()->route('user.index');
        } else {
            session()->flash('danger', '账号或密码错误');
            return redirect()->back()->withInput();
        }
    }

    public function logout(Request $request)
    {
        //判断session里面是否有值(用户是否登陆)
        if ($request->session()->has('user')) {
            //移除session
            $request->session()->pull('user', session('user'));
        }
        return redirect()->route('admin.login');
    }
}
