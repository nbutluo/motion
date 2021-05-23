<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\User\Users;
use Illuminate\Http\Request;
use App\Model\DirectoryCountryRegion;

class UserController extends ApiController
{
    public function getUser($uid)
    {
        try {
            $user = Users::findOrFail($uid);
            $user->avatar = $_SERVER["HTTP_HOST"].'/'.$user->avatar;
            return $this->success('获取成功', $user);
        } catch (\Exception $exception) {
            return $this->fail('获取失败', 404);
        }
    }

    public function getRegion()
    {
        try {
            $regions = DirectoryCountryRegion::all();
            $regionData = [];
            foreach ($regions as $region) {
                if (isset($region['province']) && !empty($region['province'])) {
                    $regionData[$region['country']][$region['province']][] = $region['city'];
                } else {
                    $regionData[$region['country']]['province'][] = $region['city'];
                }
            }

            $region = [];
            foreach ($regionData as $regionKey => $regionValue) {
                $country = [];
                $country['name'] = $regionKey;
                $country['level'] = 1;
                foreach ($regionValue as $rKey => $rValue) {
                    $province = [];
                    $province['name'] = $rKey;
                    $province['level'] = 2;
                    $city = [];
                    foreach ($rValue as $value) {
                        $city[] = $value;
                    }
                    $province['child'] = $city;
                }
                $country['child'] = $province;
                $region[] = $country;
            }
            return $this->success('获取成功', $region);
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
