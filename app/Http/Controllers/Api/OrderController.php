<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Model\Product\Option;
use App\Model\Product\Product;
use App\Model\User\Users;
use Illuminate\Http\Request;
use App\Model\SalesOrder;
use App\Model\SalesOrderItem;

class OrderController extends ApiController
{
    public function addOrder(Request $request)
    {
        try {
            $pendingOrder = $request->toArray();
            $items = json_decode($pendingOrder['items'],true);
            //创建订单
            $userData = Users::findOrFail($pendingOrder['uid']);
            $orderUser = [];
            $orderUser['customer_id'] = $pendingOrder['uid'];
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
            return $this->fail($exception->getMessage(), 4003, []);
        }
    }

    public function orders($id)
    {
        try {
            $data = [];
            $orders = SalesOrder::where('customer_id',$id)->get();
            if (!empty($orders->toArray())) {
                foreach ($orders as $order) {
                    $orderData = [];
                    $orderData = $order;
                    $orderItems = SalesOrderItem::where('order_id',$order->id)->get();
                    $items = [];
                    foreach ($orderItems as $item) {
                        $items[] = $item;
                    }
                    $orderData['items'] = $items;
                    $data[] = $orderData;
                }
            }
            return $this->success('success', $data);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 4003, []);
        }
    }

    public function update(Request $request)
    {
        $getData = $request->toArray();
        try {
            foreach (json_decode($getData['items'],true) as $item) {
                $itemData = SalesOrderItem::findOrFail($item['item_id']);
                $itemData->qty_ordered = $item['number'];
                $itemData->save();
            }
            return $this->success('success', []);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 4003, []);
        }
    }
}
