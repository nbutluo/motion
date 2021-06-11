<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\AddToCart;
use App\Model\Product\Category;
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
                    $product->cart_option_color = '';
                    $product->cart_option_size = '';
                    $product->cart_desk_img = '';
                    if (isset($option) && !empty($option)) {
                        if ($option->type == 1) {
                            $product->cart_option_color = $option;
                        } elseif ($option->type == 2) {
                            $product->cart_option_size = $option;
                        } else {
                            $product->cart_desk_img = $option;
                        }
                    }
                }

                //获取所有配件信息
//                $alloptions = Option::select(['id','type','sku','title','image','option_color','option_size'])
//                    ->where('product_id',$cart->product_id)
//                    ->where('is_active',1)
//                    ->get();
//                $typeData1 = [];  $typeData3 = [];
//                foreach ($alloptions as $alloption) {
//                    if ($alloption->type == 1) {
//                        $typeData1[] = $alloption;
//                        $typeData2 = [];
//                        foreach ($alloptions as $alloptionSize) {
//                            if ($alloptionSize->type == 2 && $alloptionSize->option_color == $alloption->option_color) {
//                                $typeData2[] = $alloptionSize;
//                            }
//                        }
//                        $alloption->option_size = $typeData2;
//                    } elseif ($alloption->type == 3) {
//                        $typeData3[] = $alloption;
//                    }
//                }
//                $product->option_color = $typeData1;
//                $product->desk_img = $typeData3;
                $data[] = $product;
            }
            return $this->success('success', $data);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 4003, []);
        }
    }

    public function change(Request $request)
    {
        try {
            if (!isset($request->items) || $request->items == '') {
                throw new \Exception('param is empty!');
            }
            $data = [];
            $token = $request->header('Authorization');
            $user = Users::where('api_token',$token)->first();
            if (!isset($user) || empty($user)) {
                throw new \Exception('please login!');
            }

            $items = json_decode($request->items,true);
            foreach ($items as $item) {
                $catMsg = AddToCart::findOrFail($item['cart_id']);
                if (!isset($catMsg) || empty($catMsg)) {
                    throw new \Exception('there is no message to change');
                }
                if (isset($user) && $user->id != $catMsg->user_id) {
                    throw new \Exception('user message is wrong!');
                }
                if (isset($catMsg) && $catMsg->product_id != $item['product_id']) {
                    throw new \Exception('cart message is wrong!');
                }
                $catMsg->qty = $item['qty'];
//                $options = '';
//                foreach ($item['options'] as $option) {
//                    $options = ($options == '') ? $option['option_id'] : $options.','.$option['option_id'];
//                }
//                $catMsg->options = $options;
                $catMsg->save();
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

    public function getRelateProducts()
    {
        try {
            $categories = Category::all();
            $allCateData = [];
//            $categories = Category::where('parent_id',1)->where('is_active',1)->get();
            $categoryData = [];
            foreach ($categories as $category) {
                if ($category->parent_id == 1 && $category->is_active == 1) {
                    $categoryData[] = $category->id;
                }
                $allCateData[$category->id] = $category->toArray();
            }
            $relates = Product::whereIn('category_id',$categoryData)->orderBy('position','DESC')->get();
            foreach ($relates as $relate) {
                //添加分类信息
                if ($relate->category_id != 0) {
                    $third_id = $relate->category_id;
                    if ($allCateData[$third_id]['parent_id'] == 0) {
                        $relate->secondCategory = $allCateData[$third_id]['name'];
                        $relate->thirdCategory = '';
                    } else {
                        $sedond_id = $allCateData[$third_id]['parent_id'];
                        $relate->secondCategory = $allCateData[$sedond_id]['name'];
                        $relate->thirdCategory = $allCateData[$third_id]['name'];
                    }
                } else {
                    $relate->secondCategory = '';
                    $relate->thirdCategory = '';
                }
                if (isset($relate->image) && $relate->image != '') {
                    $imageData = [];
                    $images = explode(';',$relate->image);
                    foreach ($images as $image) {
                        $imageData[] = HTTP_TEXT.$_SERVER["HTTP_HOST"].$image;
                    }
                    $relate->image = $imageData;
                }
            }
            return $this->success('success', $relates);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 4003, []);
        }
    }
}
