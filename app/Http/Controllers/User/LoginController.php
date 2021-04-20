<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\User\log\Ipserver;
use App\Model\User\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Model\Config\Configuration;
use App\Model\User\LoginLog;
use App\Http\Controllers\ApiController;
use Exception;

class LoginController extends ApiController
{
    public function Login(Request $request)
    {
        try {
            $data = $this->checkParams($request);

            $configuration = Configuration::pluck('val','key');
            if ($configuration['login_log'] == 1){
                $uid = isset($data['user']['id']) ? $data['user']['id'] : 0;
                $this->addlogin($data['message'],$uid);
            }
            return $this->success('登陆成功',$data['user']);
        } catch (Exception $exception) {
            return $this->fail($exception->getMessage(),$exception->getCode());
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
        $loginLog->user_agent = $userAgent;
        $loginLog->message = $message;
        $savelog =  $loginLog->save();
        if (!$savelog) {
            throw new exception('save login log fail' ,'4002');
        }
    }

    /**
     * @param $data
     * @return array
     */
    protected function checkParams($data)
    {
        $result = [];
        if ($data['username'] == '' || $data['password'] == '') {
            throw new Exception('username or password is empty','4001');
        }
        $unsearch = ['script','(select','select(','update','delete','Mr.','http','sleep(','delay \'','order by','chr(','onload','insert','XMLType','--','=','test','include','src','print','md5'];
        foreach ($unsearch as $un) {
            if (strpos(strtolower($data['username']),$un) !== false || strpos(strtolower($data['password']),$un)) {
                throw new Exception('username or password is unlawful','4001');
            }
        }

        $user = Users::where('username',$data['username'])->first();

        if (isset($user) && Hash::check($data['password'],$user['password'])) {
            if (isset($user['deleted_at'])) {
                throw new Exception('user has be delete','4001');
            } else {
                $user->api_token = $this->CreateNewToken($user['id']);
                $user->save();
                $result['user'] = $user->toArray();
                $result['message'] = 'login sucessfal';
            }
        } else {
            if (!isset($user)) {
                throw new Exception('user is not esixst!','4001');
            } else {
                throw new Exception('password is wrong!','4001');
            }

        }
        return $result;
    }

    protected function CreateNewToken($uid)
    {
        $user = Users::find($uid);
        $user->last_login = Carbon::now();

        $user->api_token = Hash::make(Str::random(60));
        $saveToken = $user->save();
        if (!$saveToken) {
            throw new Exception('create token fail','4002');
        }
        return $user->api_token;
    }

}
