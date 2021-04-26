<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\log\Ipserver;
use App\Model\Config\Configuration;
use App\Model\User\LoginLog;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Model\User\AdminUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    use AuthenticatesUsers;

//    protected $redirection = $this->redirectTo();

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.user.login');
    }

    protected function validateLogin(Request $request)
    {
//        if ($request['username'] == '' || $request['password'] == '') {
//            return false;
//        }
//        $unsearch = ['script','(select','select(','update','delete','Mr.','http','sleep(','delay \'','order by','chr(','onload','insert','XMLType','--','=','test','include','src','print','md5'];
//        foreach ($unsearch as $un) {
//            if (strpos(strtolower($request['username']),$un) !== false || strpos(strtolower($request['password']),$un)) {
//                return false;
//            }
//        }
//
//        $adminuser = AdminUser::where('username',$request['username'])->first();
//
//        if (isset($adminuser) && Hash::check($request['password'],$adminuser['password'])) {
//            if (isset($adminuser['deleted_at'])) {
//                return false;
//            }
//        } else {
//            return false;
//        }
//        return true;
        $this->validate($request,[
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function addlogin($message,$username)
    {
        $user = AdminUser::where('username',$username)->first();
        $ip = Ipserver::getRealIp();
        $method = request()->method();
        $userAgent = request()->header('User-Agent');

        $loginLog = new LoginLog;
        $loginLog->uid = $user->id;
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

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $configuration = Configuration::pluck('val','key');
            $request->session()->put('configuration', $configuration);
//            $username = $this->username();
            $this->addlogin('adminUser login successful',$request[$this->username()]);

            return $this->sendLoginResponse($request);
        }
//        if ($this->checkUser($request)) {
//            $configuration = Configuration::pluck('val','key');
//            $request->session()->put('configuration', $configuration);
//            return $this->sendLoginResponse($request);
//        }
        // 若登入失败记录一次失败
        $this->incrementLoginAttempts($request);

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

    public function logout(Request $request)
    {
        $this->guard()->logout();

        //缓存配置信息
        $configuration = Configuration::pluck('val','key');

        //删除所有session信息
        $request->session()->invalidate();

        return Redirect::to(URL::route('admin.user.login')) ?: redirect('/');
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function username()
    {
        return 'username';
    }
}
