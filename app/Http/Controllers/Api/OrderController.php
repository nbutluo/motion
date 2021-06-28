<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Product\Category;
use App\Model\Product\Option;
use App\Model\Product\Product;
use App\Model\User\AdminUser;
use App\Model\User\Users;
use Illuminate\Http\Request;
use App\Model\SalesOrder;
use App\Model\SalesOrderItem;

class OrderController extends ApiController
{
    public function addOrder(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $user = Users::where('api_token',$token)->first();
            if (!isset($user)) {
                throw new \Exception('please login!',4003);
            }
            $pendingOrder = $request->toArray();
            $items = json_decode($pendingOrder['items'],true);
            //创建订单
            $userData = Users::findOrFail($user->id);
            $orderUser = [];
            $orderUser['customer_id'] = $user->id;
            $orderUser['status'] = 'pending';
            $orderUser['customer_name'] = $userData->username;
            $orderUser['customer_email'] = $userData->email;
            $addOrder = SalesOrder::create($orderUser);
            $orderId = $addOrder->id;

            $data = [];
            $data = $addOrder->toArray();

            if ($orderId) {
                $product_options = [];
                foreach ($items as $product) {
                    $productId = $product['product_id'];
                    $productData = Product::findOrFail($product['product_id']);
                    $productOption = [];
                    $productOption['product_id'] = $product['product_id'];
                    $productOption['sku'] = $productData->sku;
                    $productOption['name'] = $productData->name;
                    $productOption['price'] = $productData->price;
                    foreach ($product['options'] as $option) {
                        $optionData = Option::findOrFail($option['option_id']);
                        $optionText = [];
                        $optionText['option_id'] = $optionData->id;
                        $optionText['sku'] = $optionData->sku;
                        $optionText['title'] = $optionData->title;
                        $optionText['type'] = $optionData->type;
                        $optionText['option_color'] = $optionData->option_color;
                        $optionText['option_size'] = $optionData->option_size;
                        $optionText['image'] = $optionData->image;
                        $optionText['pre_sale'] = $optionData->pre_sale;
                        $productOption['options'][] = $optionText;
                        $data['child'][] = $optionData->toArray();
                    }
                    //创建item
                    $addOption = [];
                    $addOption['order_id'] = $orderId;
                    $addOption['product_id'] = $product['product_id'];
                    $addOption['sku'] = $productData->sku;
                    $addOption['name'] = $productData->name;
                    $addOption['description'] = $productData->description;
                    $addOption['product_options'] = json_encode($productOption);
                    $addOption['qty_ordered'] = $product['qty'];
                    $sales_order_item = SalesOrderItem::create($addOption);
                    $data['child'][] = $sales_order_item->toArray();
                }
            }
            return $this->success('success', $data);
        } catch(\Exception $exception) {
            $code = ($exception->getCode() == 4003) ? 4003 : 4004;
            return $this->fail($exception->getMessage(), $code, []);
        }
    }

    public function orders(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $user = Users::select(['id'])->where('api_token',$token)->first();
            if (!isset($user) || empty($user)) {
                throw new \Exception('please login!');
            }
            $page = isset($request->page) ? $request->page : 1;
            $page_size = isset($request->page_size) ? $request->page_size : 4;
            $data = [];
            $allOrders = SalesOrder::select(['id'])
                ->where('customer_id',$user['id'])
                ->offset(($page-1)*$request->page_size)
                ->limit($page_size)
                ->get();
            $data['total'] = count($allOrders);
            $data['total_page'] = ceil($data['total'] / $page_size);
            $orders = SalesOrder::where('customer_id',$user['id'])->get();
            $allCateData = [];
            $categories = Category::select(['id','name','parent_id'])->get();
            foreach ($categories as $category) {
                $allCateData[$category->id] = $category->toArray();
            }
            if (!empty($orders->toArray())) {
                $allOrderData = [];
                foreach ($orders as $order) {
                    $orderData = [];
                    $customer = Users::select(['salesman'])->findOrFail($order->customer_id);
                    $salesman = ($customer->salesman != 0) ? $customer->salesman : 1;
                    $charge = AdminUser::select(['email'])->findOrFail($salesman);
                    $orderData['salesman'] = $charge->email;
                    $orderData['order_number'] = $order->id;
                    $creatTime = explode(' ',$order->created_at);
                    $orderData['create_time'] = $creatTime[0];
                    $orderItems = SalesOrderItem::select(['product_options','qty_ordered'])->where('order_id',$order->id)->get();
                    $items = [];
                    foreach ($orderItems as $item) {
                        $detail = json_decode($item->product_options,true);
                        $product = Product::select(['id','name','sku','image','category_id'])->findOrfail($detail['product_id']);
                        $product->qty = $item->qty_ordered;
                        if ($product->category_id != 0) {
                            $third_id = $product->category_id;
                            if ($allCateData[$third_id]['parent_id'] == 0) {
                                $product->secondCategory = $allCateData[$third_id]['name'];
                                $product->thirdCategory = '';
                            } else {
                                $sedond_id = $allCateData[$third_id]['parent_id'];
                                $product->secondCategory = $allCateData[$sedond_id]['name'];
                                $product->thirdCategory = $allCateData[$third_id]['name'];
                            }
                        } else {
                            $product->secondCategory = '';
                            $product->thirdCategory = '';
                        }
                        $productImages = explode(';',$product->image);
                        $product->image = (isset($productImages) && !empty($productImages)) ? HTTP_TEXT.$_SERVER["HTTP_HOST"].$productImages[0] : '';
                        foreach ($detail['options'] as $optionData) {
                            if ($optionData['type'] == 1) {
                                $product->option_color = (isset($optionData['title']) && $optionData['title'] != '') ? $optionData['title'] : '';
                            } elseif ($optionData['type'] == 2) {
                                $product->option_size = (isset($optionData['option_size']) && $optionData['option_size'] != '') ? $optionData['option_size'] : '';
                            } else {
                                $product->desk_img = ($optionData['type'] == 3 && isset($optionData['image']) && $optionData['image'] != '') ? HTTP_TEXT.$_SERVER["HTTP_HOST"].$optionData['image'] : '';
                            }
                        }
                        $items[] = $product;
                    }
                    $orderData['items'] = $items;
                    $allOrderData[] = $orderData;
                }
                $data['list'] = $allOrderData;
            }
            return $this->success('success', $data);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 4003, []);
        }
    }

    public function orderDetail(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $user = Users::select(['id'])->where('api_token',$token)->first();
            if (!isset($user) || empty($user)) {
                throw new \Exception('please login!');
            }

            $order = SalesOrder::findOrFail($request->order_id);
            $allCateData = [];
            $categories = Category::select(['id','name','parent_id'])->get();
            foreach ($categories as $category) {
                $allCateData[$category->id] = $category->toArray();
            }
            if (!empty($order)) {
                $orderData = [];
                $customer = Users::select(['salesman'])->findOrFail($order->customer_id);
                $salesman = ($customer->salesman != 0) ? $customer->salesman : 1;
                $charge = AdminUser::select(['email'])->findOrFail($salesman);
                $orderData['salesman'] = $charge->email;
                $orderData['order_number'] = $order->id;
                $creatTime = explode(' ',$order->created_at);
                $orderData['create_time'] = $creatTime[0];
                $orderItems = SalesOrderItem::select(['id','product_options','qty_ordered'])->where('order_id',$order->id)->get();
                $items = [];
                foreach ($orderItems as $item) {
                    $detail = json_decode($item->product_options,true);
                    $product = Product::select(['id','name','sku','image','category_id'])->findOrfail($detail['product_id']);
                    $product->item_id = $item->id;
                    $product->qty = $item->qty_ordered;
                    if ($product->category_id != 0) {
                        $third_id = $product->category_id;
                        if ($allCateData[$third_id]['parent_id'] == 0) {
                            $product->secondCategory = $allCateData[$third_id]['name'];
                            $product->thirdCategory = '';
                        } else {
                            $sedond_id = $allCateData[$third_id]['parent_id'];
                            $product->secondCategory = $allCateData[$sedond_id]['name'];
                            $product->thirdCategory = $allCateData[$third_id]['name'];
                        }
                    } else {
                        $product->secondCategory = '';
                        $product->thirdCategory = '';
                    }
                    $productImages = explode(';',$product->image);
                    $product->image = (isset($productImages) && !empty($productImages)) ? HTTP_TEXT.$_SERVER["HTTP_HOST"].$productImages[0] : '';
                    foreach ($detail['options'] as $optionData) {
                        if ($optionData['type'] == 1) {
                            $product->option_color = (isset($optionData['title']) && $optionData['title'] != '') ? $optionData['title'] : '';
                        } elseif ($optionData['type'] == 2) {
                            $product->option_size = (isset($optionData['option_size']) && $optionData['option_size'] != '') ? $optionData['option_size'] : '';
                        } else {
                            $product->desk_img = ($optionData['type'] == 3 && isset($optionData['image']) && $optionData['image'] != '') ? HTTP_TEXT.$_SERVER["HTTP_HOST"].$optionData['image'] : '';
                        }
                    }
                    $items[] = $product;
                }
                $orderData['items'] = $items;
                $data['list'] = $orderData;
            }
            return $this->success('success', $data);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 4003, []);
        }
    }

    public function update(Request $request)
    {
        $token = $request->header('Authorization');
        $user = Users::where('api_token',$token)->first();
        $order = SalesOrder::select(['id','customer_id'])->where('id',$request->order_id)->first();

        $getData = $request->toArray();
        try {
            if (!isset($user)) {
                throw new \Exception('please login!',4003);
            } else {
                if ($order->customer_id != $user->id) {
                    throw new \Exception('User does not match the order!',4004);
                }
            }
            foreach (json_decode($getData['items'],true) as $item) {
                $itemData = SalesOrderItem::findOrFail($item['item_id']);
                if (!isset($itemData) || $itemData->order_id != $order->id) {
                    throw new \Exception('item is not in order!',4004);
                }
                $itemData->qty_ordered = $item['number'];
                $itemData->save();
            }
            return $this->success('success', []);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), $exception->getCode(), []);
        }
    }
}
