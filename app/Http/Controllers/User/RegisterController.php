<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function create(Request $request)
    {
        $result = [];
//        $validata = $request->validate([
//            'username' => 'required|string|max:255',
//            'password' => 'required|string|min:8|confirmed|max:255',
//        ]);
//        return $validata;
        $checkResult = $this->checkParams($request);

        if (empty($checkResult)) {
            $users = new Users;
            $users->username = $request->username;
            $users->password = Hash::make($request->password);
            $users->api_token = Hash::make(Str::random(60));
            $userSave = $users->save();
            if ($userSave) {
                $result['code'] = 200;
                $result['data']['message'] = 'register successful!';
            }
        } else {
            $result = $checkResult ;
        }
        return json_encode($result);
    }

    protected function checkParams($data)
    {
        $result = [];

        $user = Users::where('username',$data['username'])->first();
        if ($user) {
            $result['code'] = '4001';
            $result['data']['message'] = 'username has exists';
        }

        if ($data['password'] != $data['password_confirmation']) {
            $result['code'] = '4001';
            $result['data']['message'] = 'password is not same';
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


        return $result;
    }
}
