<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\User\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class InformationController extends Controller
{
    public function myForm()
    {
        return View('admin.user.information');
    }

    public function infoUpdate(Request $request)
    {
        try {
            if ($this->checkParams($request)) {
                $user = auth()->user();
                $user->username = $request->username;
                $user->nickname = $request->nickname;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->save();
                return Redirect::to(URL::route('admin.user.myForm'))->with(['success' => '修改成功']);
            } else {
                return Redirect::back()->withErrors('错误的数据类型');
            }
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors('修改失败');
        }
    }

    protected function checkParams($data)
    {
        $unsearch = ['script','(select','select(','update','delete','Mr.','http','sleep(','delay \'','order by','chr(','onload','insert','XMLType','--','=','test','include','src','print','md5'];
        foreach ($unsearch as $un) {
            if (strpos(strtolower($data['username']),$un) !== false || strpos(strtolower($data['password']),$un)) {
                return false;
            }
        }
        return true;
    }
}
