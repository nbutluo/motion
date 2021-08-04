<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\User\Users;
use Illuminate\Http\Request;

class UpdateController extends ApiController
{
    public function update(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $user = Users::where('api_token',$token)->first();
            if ($user) {
                $user_avatar = '/avatars';
                $file_path = '';
                if ($request->file('avatar')) {
                    $file_path = $request->file('avatar')->store($user_avatar);
                    $file_path = HTTP_TEXT.$_SERVER["HTTP_HOST"].'/'.$file_path;
                }else {
                    throw new \Exception('please add your avatar!');
                }
            } else {
                throw new \Exception('please login!');
            }
            return $this->success('success', $file_path);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 404);
        }
    }
}
