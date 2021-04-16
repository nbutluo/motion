<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\log\Ipserver;
use App\Model\User\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Model\Config\Configuration;
use App\Model\User\LoginLog;

class LoginController extends Controller
{
    public function Login(Request $request)
    {
        $data = $this->checkParams($request);

        $configuration = Configuration::pluck('val','key');
        if ($configuration['login_log'] == 1){
            $uid = isset($data['data']['user']['id']) ? $data['data']['user']['id'] : 0;
            $this->addlogin($data['data']['message'],$uid);
        }
        return $data;
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
        $loginLog->user_agent = $userAgent;
        $loginLog->message = $message;
        $loginLog->save();
    }

    /**
     * @param $data
     * @return array
     */
    protected function checkParams($data)
    {
        $result = [];
        if ($data['username'] == '' || $data['password'] == '') {
            $result['code'] = '4001';
            $result['data']['message'] = 'username or password is empty';
            return $result;
        }
        $unsearch = ['script','(select','select(','update','delete','Mr.','http','sleep(','delay \'','order by','chr(','onload','insert','XMLType','--','=','test','include','src','print','md5'];
        foreach ($unsearch as $un) {
            if (strpos(strtolower($data['username']),$un) !== false || strpos(strtolower($data['password']),$un)) {
                $result['code'] = '4001';
                $result['data']['message'] = 'username or password is unlawful';
                return $result;
                break;
            }
        }

        $user = Users::where('username',$data['username'])->first();

        if (isset($user) && Hash::check($data['password'],$user['password'])) {
            if (isset($user['deleted_at'])) {
                $result['code'] = '4001';
                $result['data']['message'] = 'user is be delete';
                $result['data']['user']['uid'] = 'user is be delete';
            } else {
                $result['code'] = '200';
                $user->api_token = $this->CreateNewToken($user['id']);
                $user->save();
                $result['data']['user'] = $user->toArray();
                $result['data']['message'] = 'login sucessfal';
            }
        } else {
            if (!isset($user)) {
                $result['code'] = '4001';
                $result['data']['message'] = 'user is not esixst!';
            } else {
                $result['code'] = '4001';
                $result['data']['user']['id'] = $user['id'];
                $result['data']['message'] = 'password is wrong!';
            }

        }
        return $result;
    }

    protected function CreateNewToken($uid)
    {
        $user = Users::find($uid);
        $user->last_login = Carbon::now();

        $user->api_token = Hash::make(Str::random(60));
        $user->save();

        return $user->api_token;
    }
}
