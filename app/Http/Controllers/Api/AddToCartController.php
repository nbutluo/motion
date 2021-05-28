<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\AddToCart;
use App\Model\Product\Option;
use App\Model\Product\Product;
use App\Model\User\Users;
use Illuminate\Http\Request;

class AddToCartController extends ApiController
{
    public function addToCart(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $user = Users::where('api_token',$token)->first();
            $order = json_decode($request->item,true);
            $data = [];
            $data['product_id'] = $order['product_id'];
            $data['user_id'] = (isset($user) && !empty($user)) ? $user->id : 0;
            $data['qty'] = $order['qty'];
            $option_text = '';
            foreach ($order['options'] as $option) {
                $option_text = ($option_text == '') ? $option['option_id'] : $option_text.','.$option['option_id'];
            }
            $data['options'] = $option_text;
            $data['token'] = $token;
            AddToCart::create($data);
            return $this->success('success', $data);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 4003, []);
        }
    }

    public function getCart(Request $request)
    {
        try {
            $data = [];
            $token = $request->header('Authorization');
            $user = Users::where('api_token',$token)->first();
            if (isset($user) && !empty($user)) {
                $carts = AddToCart::where('user_id',$user->id)->get();
            } else {
                $carts = AddToCart::where('token',$token)->get();
            }
            foreach ($carts as $cart) {
                $product = Product::select(['id','name','sku','image'])->findOrFail($cart->product_id);
                $product->cart_id = $cart->id;
                $product->qty = $cart->qty;
                $productImages = explode(';',$product->image);
                $product->image = HTTP_TEXT.$_SERVER["HTTP_HOST"].$productImages[0];
                $optionIds = explode(',',$cart->options);
                $optionData = [];
                foreach ($optionIds as $optionId) {
                    $option = Option::select(['id','sku','title','type','image','option_color','option_size'])->findOrFail($optionId);
                    if (isset($option->image) && !empty($option->image)) {
                        $option->image = HTTP_TEXT.$_SERVER["HTTP_HOST"].$option->image;
                    }
                    $optionData[] = $option;
                }
                $product->options = $optionData;
                $data[] = $product;
            }
            return $this->success('success', $data);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 4003, []);
        }
    }

    public function destory(Request $request)
    {
        try {
            $data = [];
            $token = $request->header('Authorization');
            $user = Users::where('api_token',$token)->first();
            $carts = AddToCart::findOrFail($request->cart_id);
            if ((isset($user) && $user->id == $carts->user_id) || $token == $carts->token) {
                $destoryCart = AddToCart::findOrFail($request->cart_id);
                $destoryCart->delete();
                if ($destoryCart->trashed()){
                    $data['cart_id'] = $request->cart_id;
                    return $this->success('success', $data);
                } else {
                    throw new \Exception('fail');
                }
            } else {
                throw new \Exception('fail');
            }
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 4003, []);
        }
    }
}
