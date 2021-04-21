<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\log\Ipserver;
use App\Model\Config\Configuration;
use App\Model\User\LoginLog;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Exception;
use App\Model\User\AdminUser;
use Illuminate\Support\Facades\Hash;
use Log;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('admin.user.login');
    }

    protected function validateLogin(Request $request)
    {
        if ($request['username'] == '' || $request['password'] == '') {
            return false;
        }
        $unsearch = ['script','(select','select(','update','delete','Mr.','http','sleep(','delay \'','order by','chr(','onload','insert','XMLType','--','=','test','include','src','print','md5'];
        foreach ($unsearch as $un) {
            if (strpos(strtolower($request['username']),$un) !== false || strpos(strtolower($request['password']),$un)) {
                return false;
            }
        }

        $adminuser = AdminUser::where('username',$request['username'])->first();

        if (isset($adminuser) && Hash::check($request['password'],$adminuser['password'])) {
            if (isset($adminuser['deleted_at'])) {
                return false;
            }
        } else {
            return false;
        }
        return true;
    }

    protected function checkUser(Request $request)
    {
        $user = AdminUser::where('username',$request['username'])->first();

        if (isset($user) && Hash::check($request['password'],$user['password'])) {
            $userData = [];
            $userData['id'] = $user['id'];
            $userData['username'] = $user['username'];
            $request->session()->put('loginUser',$userData);
            //记录入日志
            $this->addlogin('adminUser login successful',$user['id']);
            return true;
        } else {
            return false;
        }
    }
    protected function addlogin($message,$uid)
    {
        $ip = Ipserver::getRealIp();
        $method = request()->method();
        $userAgent = request()->header('User-Agent');

        $loginLog = new LoginLog;
        $loginLog->uid = $uid;
        $loginLog->ip = $ip;
        $loginLog->method = $method;
        $loginLog->type = 2;
        $loginLog->user_agent = $userAgent;
        $loginLog->message = $message;
        $loginLog->save();
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->checkUser($request)) {
            $configuration = Configuration::pluck('val','key');
            $request->session()->put('configuration', $configuration);
            return $this->sendLoginResponse($request);
        }
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * 登录成功后的跳转地址
     * @return string
     */
    public function redirectTo()
    {
        return URL::route('admin.layout');
    }
}
