<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Model\User\Users;
use Illuminate\Support\Facades\Hash;
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
                $result['code'] = 200;
                $result['data']['message'] = 'register successful!';
                return $this->success('register successful!',$userSave);
            }else {
                throw new Exception('registration failed','4002');
            }
        } catch (Exception $exception) {
            return $this->fail($exception->getMessage(),$exception->getCode());
        }
    }

    public function sendEmail(Request $request)
    {
        try {
            $email = trim($request->username);
            if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
                //发送邮件
                $verifiCode = str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_BOTH);
                $sendData = [
                    'user' => $request->username,
                    'code' => $verifiCode
                ];
                Mail::to([$email])->send(new LoctekMail($sendData));
                return $this->success('register successful!',$sendData);
            } else {
                throw new Exception($request->username.' is not a email!');
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
