<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PasswordController extends Controller
{
    public function changeMyPasswordForm()
    {
        return view('admin.user.changeMyPassword');
    }

    public function changeMyPassword(Request $request)
    {
        $data = $request->all(['old_password','new_password','new_password_confirmation']);
        echo '<pre>';var_dump(auth()->user()->toArray());
        var_dump($request->toArray());
//        return Redirect::back()->withErrors('密码不正确');
//        $data = $request
        var_dump(Hash::check($request['old_password'],auth()->user()->password));

    }
}
