<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Model\User\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\ApiController;
use Exception;

class RegisterController extends ApiController
{
    public function create(Request $request)
    {
        try {
            $this->checkParams($request);

            $users = new Users;
            $users->username = $request->username;
            $users->email = $request->username;
            $users->password = Hash::make($request->password);
            $users->api_token = Hash::make(Str::random(60));
            $userSave = $users->save();
            if ($userSave) {
                $result['code'] = 200;
                $result['data']['message'] = 'register successful!';
                return $this->success('register successful!','200');
            }else {
                throw new Exception('registration failed','4002');
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
