<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\User\Users;
use Illuminate\Http\Request;
use App\Model\DirectoryCountryRegion;

class UserController extends ApiController
{
    public function getUser(Request $request)
    {
        try {
//            $user = Users::findOrFail($uid);
            $token = $request->header('Authorization');
            $user = Users::where('api_token',$token)->first();
            if (isset($user->avatar) && !empty($user->avatar)) {
                $user->avatar = HTTP_TEXT.$_SERVER["HTTP_HOST"].'/'.$user->avatar;
            } else {
                $user->avatar = '';
            }

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
            return $this->success('success', $region);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), $exception->getCode());
        }
    }

    public function editUser(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $user = Users::where('api_token',$token)->first();
            if ($user) {
                $data = $request->only(['nickname','avatar','sex','birth','email','phone','country','province','city','company_url']);

                if (isset($data['avatar'])) {
                    if (strpos($data['avatar'],'avatars') !== false) {
                        $avatar = explode('avatars',$data['avatar']);
                        $data['avatar'] = 'avatars'.$avatar[1];
                    } else {
                        throw new \Exception('avatar file is wrong!');
                    }
                } else {
                    unset($data['avatar']);
                }
                $data['nickname'] = isset($data['nickname']) ? $data['nickname'] : '';
                $data['sex'] = isset($data['sex']) ? $data['sex'] : 0;
                $data['birth'] = isset($data['birth']) ? $data['birth'] : '';
                $data['email'] = isset($data['email']) ? $data['email'] : '';
                $data['phone'] = isset($data['phone']) ? $data['phone'] : '';
                $data['country'] = isset($data['country']) ? $data['country'] : '';
                $data['province'] = isset($data['province']) ? $data['province'] : '';
                $data['city'] = isset($data['city']) ? $data['city'] : '';
                $data['area'] = isset($data['area']) ? $data['area'] : '';
                $data['company_url'] = isset($data['company_url']) ? $data['company_url'] : '';

                $user->update($data);
                if ($user->avatar != '') {
                    $user->avatar = HTTP_TEXT.$_SERVER["HTTP_HOST"].'/'.$user->avatar;
                }
                return $this->success('更新成功', $user);
            } else {
                throw new \Exception('Please log in correctly!');
            }
        } catch(\Exception $exception) {
            return $this->fail($exception->getMessage(), 404);
        }
    }
}
