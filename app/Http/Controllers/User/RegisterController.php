<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Model\User\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Http\Controllers\ApiController;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoctekMail;

class RegisterController extends ApiController
{
    public function create(Request $request)
    {
        try {
            $verify = $request->verification;
            $verifyCode = session($request->username);
            if ($verify == $verifyCode) {
                $this->checkParams($request);
                $params = [];
                $params['username'] = $request->username;
                $params['email'] = $request->username;
                $params['country'] = isset($request->country) ? $request->country : '';
                $params['company_url'] = isset($request->company) ? $request->company : '';
                $params['password'] = Hash::make($request->password);
                $params['api_token'] = Hash::make(Str::random(60));
                $userSave = Users::create($params);
                if ($userSave) {
                    Session::pull($request->username,'');//清除session
                    $result['code'] = 200;
                    $result['data']['message'] = 'register successful!';
                    return $this->success('register successful!',$userSave);
                }else {
                    throw new Exception('registration failed','403');
                }
            } else {
                throw new Exception('verify code is wrong!','403');
            }
        } catch (Exception $exception) {
            return $this->fail($exception->getMessage(),$exception->getCode());
        }
    }

    protected function checkParams($data)
    {
        $user = Users::where('username',$data['username'])->first();

        if ($user) {
            throw new Exception('username has exists','4001');
        }

        if ($data['password'] != $data['password_confirmation']) {
            throw new Exception('password is not same','4001');
        }

        $unsearch = ['script','(select','select(','update','delete','Mr.','http','sleep(','delay \'','order by','chr(','onload','insert','XMLType','--','=','test','include','src','print','md5'];
        foreach ($unsearch as $un) {
            if (strpos(strtolower($data['username']),$un) !== false || strpos(strtolower($data['password']),$un)) {
                throw new Exception('username or password is unlawful','4001');
                break;
            }
        }
    }
}
