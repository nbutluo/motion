<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Product\Product;
use App\Model\SalesOrder;
use App\Model\SalesOrderItem;
use App\Model\User\AdminUser;
use App\Model\User\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class OrderController extends AdminController
{
    public function index()
    {
        return view('admin.order.index');
    }

    public function getList(Request $request)
    {
        $orders = SalesOrder::paginate($request->get('limit',30));
        foreach ($orders as $order) {
            $salesman = AdminUser::findOrFail($order->salesman);
            $order->salesman = $salesman->nickname;
        }
        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $orders->total(),
            'data' => $orders->items()
        ];
        return Response::json($data);
    }

    public function edit($id)
    {
        $data = [];
        $order = SalesOrder::findOrFail($id);
        $data['status'] = $order->status;
        $data['customer_name'] = $order->customer_name;
        $data['customer_email'] = $order->customer_email;
        $data['order_price'] = $order->grand_total;
        $data['salesman'] = $order->salesman;
        $orderItems = SalesOrderItem::where('order_id',$id)->get();
        foreach ($orderItems as $orderItem) {
            $product = Product::findOrFail($orderItem->product_id);
            $itemData = [];
            $itemData['item_id'] = $orderItem->id;
            $itemData['product_id'] = $product->id;
            $itemData['product_name'] = $product->name;
            $itemData['product_sku'] = $product->sku;
            $itemData['product_image'] = $product->image;
            $itemData['product_image_label'] = $product->image_label;
            $itemData['product_qty'] = $orderItem->qty_ordered;
            $itemData['item_price'] = $orderItem->price;
            $item = $orderItem->toArray();
            $product_options = json_decode($item['product_options'],true);
            foreach ($product_options['options'] as $product_option) {
                $option = [];
                if ($product_option['type'] == 1) {
                    $option['option_color'] = $product_option['option_color'];
                } elseif ($product_option['type'] == 2) {
                    $option['option_size'] = $product_option['option_size'];
                } elseif ($product_option['type'] == 3) {
                    $option['image'] = $product_option['image'];
                }
                $itemData['child'][] = $option;
            }
            $data['items'][] = $itemData;
        }
        $salesmans = AdminUser::where('rule_id','like','%3')->get();
        return view('admin.order.edit',compact('id','data','salesmans'));
    }

    public function update(Request $request)
    {
        try {
            $orderData = [];
            $orderData['status'] = $request->status;
            $orderData['grand_total'] = isset($request->order_price) ? $request->order_price : 0;
            $orderData['customer_email'] = isset($request->customer_email) ? $request->customer_email : '';
            if (isset($request->salesman) && !empty($request->salesman)) {
                $orderData['salesman'] = $request->salesman;
            }
            $order = SalesOrder::findOrfail($request->order_id);
            $order->update($orderData);
            $order_items = [];
            $data = $request->toArray();
            foreach ($data as $key => $value) {
                if (strpos($key,'item_price') !== false) {
                    preg_match('/\d+/',$key,$number);
                    $order_items[] = $number[0];
                }
            }
            foreach ($order_items as $order_item) {
                $item = SalesOrderItem::findOrFail($order_item);
                $itemDate = [];
                $itemDate['price'] = $data['item_price_'.$order_item];
                $itemDate['qty_ordered'] = $data['item_qty_'.$order_item];
                $item->update($itemDate);
            }
            return Redirect::to(URL::route('admin.order.index'))->with(['success' => '更新成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }
}
