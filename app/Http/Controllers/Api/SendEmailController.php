<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Mail\LoctekMail;
use App\Mail\LoctekWishListMail;
use App\Model\Product\Option;
use App\Model\Product\Product;
use App\Model\User\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends ApiController
{
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
//                $sessionCode = md5(str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_BOTH));
                session([$request->username => $verifiCode]);
                $data = [
                    'user' => $request->username,
//                    'code' => $sessionCode
                ];
                Mail::to([$email])->send(new LoctekMail($sendData));
                return $this->success('send email successful!',$data);
            } else {
                throw new \Exception($request->username.' is not a email!');
            }
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(),$exception->getCode());
        }
    }

    public function sendWishList(Request $request)
    {
        try {
            $data = [];
            $token = $request->header('Authorization');
            if (isset($token) && $token != '') {
                $user = Users::select(['id','username','nickname','user_level'])->where('api_token',$token)->first();
                $data['user'] = (isset($user->nickname) && $user->nickname != '') ? $user->nickname : $user->username;
                $userLevel = '普通用户';
                if ($user->user_level == 1) {
                    $userLevel = '一级用户';
                } elseif ($user->user_level == 2) {
                    $userLevel = '二级用户';
                }
                $data['user_level'] = $userLevel;
            } else {
                throw new \Exception('please login!');
            }
            $items = json_decode($request->items,true);
            $productList = [];
            foreach ($items as $item) {
                $productChild = [];
                $product = Product::findOrFail($item['product_id']);
                $productChild['product_name'] = $product->name;
                $productChild['product_sku'] = $product->sku;
                $productImages = explode(';',$product->image);
                $productChild['product_image'] = (isset($productImages[0]) && $productImages[0] != '') ? HTTP_TEXT.$_SERVER["HTTP_HOST"].$productImages[0] : '';
                $optionData = [];
                foreach ($item['options'] as $wishOption) {
                    $option = Option::select(['id','sku','title','type','image','option_color','option_size'])->findOrFail($wishOption);
                    if (isset($option) && !empty($option)) {
                        if ($option->type == 1) {
                            $optionData['option_color'] =  $option->option_color;
                        } elseif ($option->type == 2) {
                            $optionData['option_size'] =  $option->option_size;
                        } else {
                            $optionData['desk_img'] =  $option->image;
                        }
                    }
                }
                $productChild['options'] = $optionData;
                $productList[] = $productChild;

            }
            $data['list'] = $productList;
//            Mail::to([$user->username])->send(new LoctekWishListMail($data));
            Mail::to(['872029501@qq.com'])->send(new LoctekWishListMail($data));
            return $this->success('send email successful!',$data);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(),$exception->getCode());
        }

    }
}
