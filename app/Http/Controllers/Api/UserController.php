<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\User\Users;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    public function getUser($uid)
    {
        try {
            $user = Users::findOrFail($uid);
            return $this->success('获取成功', $user);
        } catch (\Exception $exception) {
            return $this->fail('获取失败', 404);
        }
    }

    public function editUser(Request $request)
    {
        try {
            $user = Users::findOrFail($request->id);
            $user_avatar = '/avatars';
            $file_path = $request->file('avatar')->store($user_avatar);
            $data = $request->only(['nickname','avatar','sex','birth','email','phone','country','province','city','area','company_url']);
            $data['avatar'] = $file_path;
            /*$name = basename($file_path);*/

            $user->update($data);
            return $this->success('更新成功', $user);
        } catch(\Exception $exception) {
            return $this->fail('更新失败。', 404);
        }
    }
}
