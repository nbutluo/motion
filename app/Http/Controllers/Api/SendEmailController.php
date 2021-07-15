<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Mail\LoctekMail;
use App\Mail\LoctekWishListMail;
use App\Model\Product\Option;
use App\Model\Product\Product;
use App\Model\User\AdminUser;
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
                $user = Users::select(['id','username','nickname','user_level','country','company_url','salesman'])->where('api_token',$token)->first();
                if ($user->salesman == 0) {
                    $data['salesman'] = 'sales@loctek.com';
                    $salesman = AdminUser::select(['email'])->where('username','root')->first();
                } else {
                    $salesman = AdminUser::select(['email'])->where('id',$user->salesman)->first();
                }
                $data['salesman'] = isset($salesman->email) ? $salesman->email : 'catherine@loctekmotion.com';
                $data['user'] = (isset($user->nickname) && $user->nickname != '') ? $user->nickname : $user->username;
                $data['email'] = $user->username;
                $data['country'] = (isset($user->country) && $user->country != '') ? $user->country : '';
                $data['company'] = (isset($user->company_url) && $user->company_url != '') ? $user->company_url : '';
                $data['order_date'] = date('Y/m/d',time());
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
                $productChild['product_qty'] = $item['qty'];
                $productImages = explode(';',$product->image);
                $productChild['product_image'] = (isset($productImages[0]) && $productImages[0] != '') ? HTTP_TEXT.$_SERVER["HTTP_HOST"].$productImages[0] : '';
                $optionData = [];
                foreach ($item['options'] as $wishOption) {
                    $option = Option::select(['id','sku','title','type','image','option_color','option_size'])->findOrFail($wishOption);
                    if (isset($option) && !empty($option)) {
                        foreach ($option as $op) {
                            if ($op->type == 1) {
                                $optionData['option_color'] =  $op->option_color;
                                $productChild['option_color'] = $op->title;
                            } elseif ($op->type == 2) {
                                $optionData['option_size'] =  $op->option_size;
                                $productChild['option_size'] = $op->title;
                            } else {
                                $optionData['desk_img'] =  $op->image;
                                $productChild['desk_img'] =  (isset($op->image) && $op->image != '') ? HTTP_TEXT.$_SERVER["HTTP_HOST"].$op->image : '';
                            }
                        }
                    }
                }
                $productChild['options'] = $optionData;
                $productList[] = $productChild;

            }
            $data['list'] = $productList;
            Mail::to([$data['salesman']])->send(new LoctekWishListMail($data));
//            Mail::to(['872029501@qq.com'])->send(new LoctekWishListMail($data));
            return $this->success('send email successful!',$data);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(),$exception->getCode());
        }

    }
}
