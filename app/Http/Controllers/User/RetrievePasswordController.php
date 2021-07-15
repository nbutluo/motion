<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Model\User\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class RetrievePasswordController extends ApiController
{
    public function changePassword(Request $request)
    {
        try {
            $verify = $request->verify_code;
            $verifyCode = session($request->username);
            if ($verify == $verifyCode) {
                $username = $request->username;
                $password = $request->password;
                $password_confirmation = $request->password_confirmation;
                if (isset($password) && isset($password_confirmation) && $password != '' && $password_confirmation != '' && $password == $password_confirmation) {
                    $user = Users::where('username',$username)->first();
                    if ($user) {
                        Session::pull($request->username,'');//清除session
                        $parames['password'] = Hash::make($password);
                        $parames['api_token'] = Hash::make(Str::random(60));
                        Users::where('username',$username)->update($parames);
                        return $this->success('success', ['token'=>$parames['api_token']]);
                    }else {
                        throw new \Exception('user is no exist!');
                    }
                } else {
                    throw new \Exception('password can not empty or password is not same!');
                }
            } else {
                throw new \Exception('verify code is wrong!','403');
            }
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 403, []);
        }
    }
}
