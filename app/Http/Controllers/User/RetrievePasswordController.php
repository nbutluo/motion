<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Model\User\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class RetrievePasswordController extends ApiController
{
    public function changePassword(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $password = $request->password;
            $password_confirmation = $request->password_confirmation;
            if (isset($password) && isset($password_confirmation) && $password != '' && $password_confirmation != '' && $password == $password_confirmation) {
                $user = Users::where('api_token',$token)->first();
                if ($user) {
                    $parames['password'] = Hash::make($password);
                    $parames['api_token'] = Hash::make(Str::random(60));
                    Users::where('api_token',$token)->update($parames);
                    return $this->success('success', ['token'=>$parames['api_token']]);
                }else {
                    throw new \Exception('please login again!');
                }
            } else {
                throw new \Exception('password can not empty!');
            }
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 4003, []);
        }
    }
}
